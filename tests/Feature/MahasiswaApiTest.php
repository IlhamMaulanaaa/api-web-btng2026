<?php

namespace Tests\Feature;

use App\Models\Mahasiswa;
use Database\Seeders\MahasiswaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MahasiswaApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MahasiswaSeeder::class);
    }

    public function test_can_load_interactive_documentation_page(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('API Mahasiswa');
    }

    public function test_can_list_all_mahasiswa(): void
    {
        $response = $this->getJson('/api/mahasiswa');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'total' => 11,
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'total',
                'data' => [
                    '*' => ['id', 'nama', 'nim', 'jurusan', 'angkatan', 'created_at', 'updated_at']
                ]
            ]);
    }

    public function test_can_search_mahasiswa_by_name(): void
    {
        $response = $this->getJson('/api/mahasiswa?q=Budi');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertNotEmpty($response->json('data'));
        $this->assertEquals('Budi Santoso', $response->json('data.0.nama'));
    }

    public function test_can_show_single_mahasiswa(): void
    {
        $first = Mahasiswa::first();

        $response = $this->getJson("/api/mahasiswa/{$first->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $first->id,
                    'nim' => $first->nim,
                ]
            ]);
    }

    public function test_show_non_existent_mahasiswa_returns_404(): void
    {
        $response = $this->getJson('/api/mahasiswa/999999');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_validation_fails_when_creating_mahasiswa_with_missing_fields(): void
    {
        $response = $this->postJson('/api/mahasiswa', []);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'errors' => ['nama', 'nim', 'jurusan', 'angkatan']
            ]);
    }

    public function test_can_create_new_mahasiswa(): void
    {
        $payload = [
            'nama' => 'Aditya Pratama',
            'nim' => 'A11.2024.99999',
            'jurusan' => 'Teknik Informatika',
            'angkatan' => 2024,
        ];

        $response = $this->postJson('/api/mahasiswa', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => [
                    'nama' => 'Aditya Pratama',
                    'nim' => 'A11.2024.99999',
                ]
            ]);

        $this->assertDatabaseHas('mahasiswas', [
            'nim' => 'A11.2024.99999',
        ]);
    }

    public function test_duplicate_nim_returns_422(): void
    {
        $first = Mahasiswa::first();

        $payload = [
            'nama' => 'Duplikat NIM',
            'nim' => $first->nim,
            'jurusan' => 'Sistem Informasi',
            'angkatan' => 2024,
        ];

        $response = $this->postJson('/api/mahasiswa', $payload);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ])
            ->assertJsonValidationErrors(['nim']);
    }

    public function test_can_update_mahasiswa(): void
    {
        $first = Mahasiswa::first();

        $response = $this->putJson("/api/mahasiswa/{$first->id}", [
            'nama' => 'Budi Santoso Update',
            'angkatan' => 2024,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'nama' => 'Budi Santoso Update',
                    'angkatan' => 2024,
                ]
            ]);

        $this->assertDatabaseHas('mahasiswas', [
            'id' => $first->id,
            'nama' => 'Budi Santoso Update',
        ]);
    }

    public function test_can_delete_mahasiswa(): void
    {
        $first = Mahasiswa::first();

        $response = $this->deleteJson("/api/mahasiswa/{$first->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseMissing('mahasiswas', [
            'id' => $first->id,
        ]);
    }

    public function test_can_reset_database(): void
    {
        // Add extra and delete one
        Mahasiswa::create([
            'nama' => 'Random Extra',
            'nim' => 'X99.9999',
            'jurusan' => 'Random',
            'angkatan' => 2024,
        ]);

        $response = $this->postJson('/api/reset');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'total' => 11,
            ]);

        $this->assertEquals(11, Mahasiswa::count());
        $this->assertDatabaseMissing('mahasiswas', ['nim' => 'X99.9999']);
    }

    public function test_invalid_nim_format_returns_422(): void
    {
        $payload = [
            'nama'     => 'Format Salah',
            'nim'      => 'A11-2024-15656', // Menggunakan strip bukan titik
            'jurusan'  => 'Teknik Informatika',
            'angkatan' => 2024,
        ];

        $response = $this->postJson('/api/mahasiswa', $payload);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ])
            ->assertJsonValidationErrors(['nim']);
    }

    public function test_can_show_mahasiswa_by_nim(): void
    {
        $first = Mahasiswa::first();

        $response = $this->getJson("/api/mahasiswa/nim/{$first->nim}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'nim' => $first->nim,
                    'nama' => $first->nama,
                ]
            ]);
    }

    public function test_can_access_scramble_openapi_json_and_scalar_ui(): void
    {
        // OpenAPI Spec JSON Scramble
        $jsonResponse = $this->get('/docs/api.json');
        $jsonResponse->assertStatus(200);

        // Scalar UI Scramble
        $uiResponse = $this->get('/docs/api');
        $uiResponse->assertStatus(200);
    }
}
