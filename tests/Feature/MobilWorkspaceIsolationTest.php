<?php

namespace Tests\Feature;

use App\Models\Mobil;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MobilWorkspaceIsolationTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_access_custom_workspace_and_it_auto_seeds(): void
    {
        $response = $this->getJson('/api/A11.2024.15656/mobil');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('ruang', 'A11.2024.15656')
            ->assertJsonPath('total', 12);

        $this->assertEquals(12, Mobil::where('ruang', 'A11.2024.15656')->count());
    }

    public function test_two_students_have_isolated_records(): void
    {
        // Akses ruang A dan ruang B (trigger lazy auto-seeding 12 items each)
        $this->getJson('/api/ruang-a/mobil')->assertStatus(200);
        $this->getJson('/api/ruang-b/mobil')->assertStatus(200);

        // Tambah mobil khusus di ruang A
        $responseA = $this->postJson('/api/ruang-a/mobil', [
            'nama'        => 'Mobil Khusus Siswa A',
            'brand'       => 'Toyota',
            'harga'       => 500000000,
            'tahun'       => 2024,
            'transmisi'   => 'CVT',
            'bahan_bakar' => 'Hybrid',
            'status'      => 'tersedia',
        ]);
        $responseA->assertStatus(201);

        // Pastikan mobil tersebut hanya muncul di ruang A
        $this->getJson('/api/ruang-a/mobil?q=Khusus')
            ->assertStatus(200)
            ->assertJsonPath('total', 1);

        // Pastikan tidak muncul di ruang B
        $this->getJson('/api/ruang-b/mobil?q=Khusus')
            ->assertStatus(200)
            ->assertJsonPath('total', 0);
    }

    public function test_student_cannot_view_or_edit_or_delete_other_students_car(): void
    {
        // Trigger auto-seed
        $this->getJson('/api/budi/mobil')->assertStatus(200);
        $this->getJson('/api/siti/mobil')->assertStatus(200);

        $mobilBudi = Mobil::where('ruang', 'budi')->first();

        // Siti mencoba melihat ID milik Budi di kamarnya sendiri
        $this->getJson("/api/siti/mobil/{$mobilBudi->id}")
            ->assertStatus(404)
            ->assertJsonPath('success', false);

        // Siti mencoba mengedit mobil milik Budi
        $this->putJson("/api/siti/mobil/{$mobilBudi->id}", [
            'status' => 'sold',
        ])
            ->assertStatus(404)
            ->assertJsonPath('success', false);

        // Siti mencoba menghapus mobil milik Budi
        $this->deleteJson("/api/siti/mobil/{$mobilBudi->id}")
            ->assertStatus(404)
            ->assertJsonPath('success', false);

        // Verifikasi bahwa mobil Budi tetap aman
        $this->assertDatabaseHas('mobils', [
            'id'    => $mobilBudi->id,
            'ruang' => 'budi',
        ]);
    }

    public function test_reset_only_affects_targeted_workspace(): void
    {
        // Ruang Budi & Ruang Siti
        $this->getJson('/api/budi/mobil')->assertStatus(200);
        $this->getJson('/api/siti/mobil')->assertStatus(200);

        // Siti menambah 1 mobil baru sehingga total 13
        $this->postJson('/api/siti/mobil', [
            'nama'        => 'Mobil Ekstra Siti',
            'brand'       => 'Honda',
            'harga'       => 450000000,
            'tahun'       => 2024,
            'transmisi'   => 'CVT',
            'bahan_bakar' => 'Bensin',
            'status'      => 'tersedia',
        ])->assertStatus(201);

        $this->assertEquals(13, Mobil::where('ruang', 'siti')->count());

        // Budi mereset kamarnya sendiri
        $responseReset = $this->postJson('/api/budi/reset');
        $responseReset->assertStatus(200)
            ->assertJsonPath('ruang', 'budi')
            ->assertJsonPath('total_mobil', 12);

        // Kamar Siti tidak terpengaruh dan tetap berisi 13 mobil
        $this->assertEquals(13, Mobil::where('ruang', 'siti')->count());
    }
}
