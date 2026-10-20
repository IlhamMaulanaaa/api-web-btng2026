<?php

namespace Tests\Feature;

use App\Models\Mobil;
use Database\Seeders\MobilSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MobilApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MobilSeeder::class);
    }

    public function test_can_load_interactive_documentation_page(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('API Showroom Mobil');
    }

    public function test_can_list_all_mobils(): void
    {
        $response = $this->getJson('/api/mobil');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'total'   => 12,
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'ruang',
                'total',
                'data' => [
                    '*' => [
                        'id',
                        'ruang',
                        'nama',
                        'brand',
                        'harga',
                        'tahun',
                        'transmisi',
                        'bahan_bakar',
                        'status',
                        'foto',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);
    }

    public function test_can_search_mobil_by_name(): void
    {
        $response = $this->getJson('/api/mobil?q=Civic');

        $response->assertStatus(200)
            ->assertJsonPath('success', true);

        $this->assertNotEmpty($response->json('data'));
        $this->assertStringContainsString('Civic', $response->json('data.0.nama'));
    }

    public function test_can_filter_mobil_by_brand(): void
    {
        $response = $this->getJson('/api/mobil?brand=Toyota');

        $response->assertStatus(200)
            ->assertJsonPath('success', true);

        foreach ($response->json('data') as $mobil) {
            $this->assertEquals('Toyota', $mobil['brand']);
        }
    }

    public function test_can_filter_mobil_by_transmisi(): void
    {
        $response = $this->getJson('/api/mobil?transmisi=CVT');

        $response->assertStatus(200)
            ->assertJsonPath('success', true);

        foreach ($response->json('data') as $mobil) {
            $this->assertEquals('CVT', $mobil['transmisi']);
        }
    }

    public function test_can_filter_mobil_by_bahan_bakar(): void
    {
        $response = $this->getJson('/api/mobil?bahan_bakar=Listrik');

        $response->assertStatus(200)
            ->assertJsonPath('success', true);

        foreach ($response->json('data') as $mobil) {
            $this->assertEquals('Listrik', $mobil['bahan_bakar']);
        }
    }

    public function test_can_filter_mobil_by_status(): void
    {
        $response = $this->getJson('/api/mobil?status=sold');

        $response->assertStatus(200)
            ->assertJsonPath('success', true);

        foreach ($response->json('data') as $mobil) {
            $this->assertEquals('sold', $mobil['status']);
        }
    }

    public function test_can_filter_mobil_by_price_range(): void
    {
        $response = $this->getJson('/api/mobil?harga_min=500000000&harga_max=800000000');

        $response->assertStatus(200)
            ->assertJsonPath('success', true);

        foreach ($response->json('data') as $mobil) {
            $this->assertGreaterThanOrEqual(500000000, $mobil['harga']);
            $this->assertLessThanOrEqual(800000000, $mobil['harga']);
        }
    }

    public function test_can_show_single_mobil(): void
    {
        $mobil = Mobil::first();

        $response = $this->getJson("/api/mobil/{$mobil->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id'   => $mobil->id,
                    'nama' => $mobil->nama,
                ]
            ]);
    }

    public function test_returns_404_when_mobil_not_found(): void
    {
        $response = $this->getJson('/api/mobil/99999');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_can_create_new_mobil(): void
    {
        $payload = [
            'nama'        => 'Hyundai Stargazer X Prime',
            'brand'       => 'Hyundai',
            'harga'       => 335000000,
            'tahun'       => 2024,
            'transmisi'   => 'CVT',
            'bahan_bakar' => 'Bensin',
            'status'      => 'tersedia',
            'foto'        => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?w=800&q=80',
        ];

        $response = $this->postJson('/api/mobil', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => [
                    'nama'  => 'Hyundai Stargazer X Prime',
                    'brand' => 'Hyundai',
                    'ruang' => 'public',
                ]
            ]);

        $this->assertDatabaseHas('mobils', [
            'nama'  => 'Hyundai Stargazer X Prime',
            'ruang' => 'public',
        ]);
    }

    public function test_validates_required_fields_when_creating_mobil(): void
    {
        $response = $this->postJson('/api/mobil', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nama', 'brand', 'harga', 'tahun', 'transmisi', 'bahan_bakar', 'status']);
    }

    public function test_validates_enum_transmisi_and_bahan_bakar(): void
    {
        $payload = [
            'nama'        => 'Mobil Custom',
            'brand'       => 'Custom',
            'harga'       => 300000000,
            'tahun'       => 2024,
            'transmisi'   => 'OtomatisBiasa', // Invalid enum
            'bahan_bakar' => 'Nuklir',        // Invalid enum
            'status'      => 'tersedia',
        ];

        $response = $this->postJson('/api/mobil', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['transmisi', 'bahan_bakar']);
    }

    public function test_can_update_mobil_data(): void
    {
        $mobil = Mobil::first();

        $response = $this->putJson("/api/mobil/{$mobil->id}", [
            'status' => 'sold',
            'harga'  => 260000000,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id'     => $mobil->id,
                    'status' => 'sold',
                    'harga'  => 260000000,
                ]
            ]);

        $this->assertDatabaseHas('mobils', [
            'id'     => $mobil->id,
            'status' => 'sold',
            'harga'  => 260000000,
        ]);
    }

    public function test_can_delete_mobil(): void
    {
        $mobil = Mobil::first();

        $response = $this->deleteJson("/api/mobil/{$mobil->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'id'      => $mobil->id,
            ]);

        $this->assertDatabaseMissing('mobils', [
            'id' => $mobil->id,
        ]);
    }

    public function test_can_reset_mobil_data(): void
    {
        // Hapus semua mobil di ruang public
        Mobil::where('ruang', 'public')->delete();
        $this->assertEquals(0, Mobil::where('ruang', 'public')->count());

        // Jalankan reset
        $response = $this->postJson('/api/reset');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertEquals(12, Mobil::where('ruang', 'public')->count());
    }
}
