<?php

namespace Tests\Feature;

use App\Models\Mahasiswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorkspaceIsolationTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_access_custom_workspace_and_it_auto_seeds(): void
    {
        $response = $this->getJson('/api/A11.2024.15656/mahasiswa');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('ruang', 'A11.2024.15656')
            ->assertJsonPath('total', 11);

        $this->assertEquals(11, Mahasiswa::where('ruang', 'A11.2024.15656')->count());
    }

    public function test_two_students_have_isolated_records(): void
    {
        // Akses ruang A dan ruang B
        $this->getJson('/api/ruang-a/mahasiswa')->assertStatus(200);
        $this->getJson('/api/ruang-b/mahasiswa')->assertStatus(200);

        // Tambah data khusus di ruang A
        $responseA = $this->postJson('/api/ruang-a/mahasiswa', [
            'nama'     => 'Mahasiswa Khusus Ruang A',
            'nim'      => 'A11.2024.99001',
            'jurusan'  => 'Teknik Informatika',
            'angkatan' => 2024,
        ]);
        $responseA->assertStatus(201);

        // Cek bahwa data tersebut hanya ada di ruang A, tidak ada di ruang B
        $this->getJson('/api/ruang-a/mahasiswa?q=Khusus')
            ->assertStatus(200)
            ->assertJsonPath('total', 1);

        $this->getJson('/api/ruang-b/mahasiswa?q=Khusus')
            ->assertStatus(200)
            ->assertJsonPath('total', 0);
    }

    public function test_same_nim_can_exist_in_different_workspaces(): void
    {
        $payload = [
            'nama'     => 'Budi Test',
            'nim'      => 'A11.2024.77777',
            'jurusan'  => 'Teknik Informatika',
            'angkatan' => 2024,
        ];

        // Buat di ruang Budi
        $this->postJson('/api/budi/mahasiswa', $payload)->assertStatus(201);

        // Buat NIM yang sama di ruang Siti -> Harus berhasil (tidak tabrakan)
        $this->postJson('/api/siti/mahasiswa', $payload)->assertStatus(201);

        // Buat NIM yang sama lagi di ruang Budi -> Harus gagal 422 karena duplikat di ruang sendiri
        $responseDuplicate = $this->postJson('/api/budi/mahasiswa', $payload);
        $responseDuplicate->assertStatus(422)
            ->assertJsonValidationErrors(['nim']);
    }

    public function test_cannot_mutate_or_view_other_workspace_record_by_id(): void
    {
        // Buat data di ruang A
        $resA = $this->postJson('/api/ruang-a/mahasiswa', [
            'nama'     => 'Target Isolasi',
            'nim'      => 'A11.2024.88888',
            'jurusan'  => 'Sistem Informasi',
            'angkatan' => 2024,
        ]);
        $idA = $resA->json('data.id');

        // Ruang B mencoba membaca ID dari Ruang A -> Harus 404
        $this->getJson("/api/ruang-b/mahasiswa/{$idA}")->assertStatus(404);

        // Ruang B mencoba mengupdate ID dari Ruang A -> Harus 404
        $this->putJson("/api/ruang-b/mahasiswa/{$idA}", [
            'nama' => 'Nama Diretas',
        ])->assertStatus(404);

        // Ruang B mencoba menghapus ID dari Ruang A -> Harus 404
        $this->deleteJson("/api/ruang-b/mahasiswa/{$idA}")->assertStatus(404);

        // Verifikasi nama di ruang A tidak berubah
        $this->assertDatabaseHas('mahasiswas', [
            'id'    => $idA,
            'ruang' => 'ruang-a',
            'nama'  => 'Target Isolasi',
        ]);
    }

    public function test_reset_only_affects_targeted_workspace(): void
    {
        // Ruang A dan B diinisialisasi
        $this->getJson('/api/ruang-a/mahasiswa');
        $this->getJson('/api/ruang-b/mahasiswa');

        // Tambah mahasiswa di ruang A
        $this->postJson('/api/ruang-a/mahasiswa', [
            'nama'     => 'Data Penting Ruang A',
            'nim'      => 'A11.2024.11111',
            'jurusan'  => 'Teknik Informatika',
            'angkatan' => 2024,
        ])->assertStatus(201);

        $this->assertEquals(12, Mahasiswa::where('ruang', 'ruang-a')->count());

        // Reset ruang B
        $this->postJson('/api/ruang-b/reset')
            ->assertStatus(200)
            ->assertJsonPath('ruang', 'ruang-b');

        // Ruang A harus tetap 12 (tidak ikut terhapus!)
        $this->assertEquals(12, Mahasiswa::where('ruang', 'ruang-a')->count());
        // Ruang B kembali ke 11 seeder
        $this->assertEquals(11, Mahasiswa::where('ruang', 'ruang-b')->count());
    }

    public function test_can_lookup_by_nim_in_workspace(): void
    {
        $this->getJson('/api/ruang-a/mahasiswa');

        $response = $this->getJson('/api/ruang-a/mahasiswa/nim/A11.2024.15656');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.nim', 'A11.2024.15656');
    }
}
