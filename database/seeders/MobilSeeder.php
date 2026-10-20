<?php

namespace Database\Seeders;

use App\Models\Mobil;
use Illuminate\Database\Seeder;

class MobilSeeder extends Seeder
{
    /**
     * Default dataset of 12 starter cars with HD photos and diverse attributes.
     */
    public static function defaultCars(): array
    {
        return [
            [
                'nama'        => 'Toyota Avanza 1.5 G CVT',
                'brand'       => 'Toyota',
                'harga'       => 275000000,
                'tahun'       => 2024,
                'transmisi'   => 'CVT',
                'bahan_bakar' => 'Bensin',
                'status'      => 'tersedia',
                'foto'        => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?w=800&q=80',
            ],
            [
                'nama'        => 'Honda Civic RS Turbo',
                'brand'       => 'Honda',
                'harga'       => 616000000,
                'tahun'       => 2023,
                'transmisi'   => 'CVT',
                'bahan_bakar' => 'Bensin',
                'status'      => 'tersedia',
                'foto'        => 'https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?w=800&q=80',
            ],
            [
                'nama'        => 'Mitsubishi Pajero Sport Dakar 4x2',
                'brand'       => 'Mitsubishi',
                'harga'       => 635000000,
                'tahun'       => 2023,
                'transmisi'   => 'Matic',
                'bahan_bakar' => 'Diesel',
                'status'      => 'tersedia',
                'foto'        => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?w=800&q=80',
            ],
            [
                'nama'        => 'Hyundai Ioniq 5 Signature Long Range',
                'brand'       => 'Hyundai',
                'harga'       => 895000000,
                'tahun'       => 2024,
                'transmisi'   => 'Matic',
                'bahan_bakar' => 'Listrik',
                'status'      => 'tersedia',
                'foto'        => 'https://images.unsplash.com/photo-1593941707882-a5bba14938c7?w=800&q=80',
            ],
            [
                'nama'        => 'Toyota Kijang Innova Zenix Hybrid 2.0 V',
                'brand'       => 'Toyota',
                'harga'       => 542000000,
                'tahun'       => 2024,
                'transmisi'   => 'CVT',
                'bahan_bakar' => 'Hybrid',
                'status'      => 'tersedia',
                'foto'        => 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?w=800&q=80',
            ],
            [
                'nama'        => 'Suzuki Jimny 1.5 4x4 MT',
                'brand'       => 'Suzuki',
                'harga'       => 445000000,
                'tahun'       => 2023,
                'transmisi'   => 'Manual',
                'bahan_bakar' => 'Bensin',
                'status'      => 'tersedia',
                'foto'        => 'https://images.unsplash.com/photo-1563720223185-11003d516935?w=800&q=80',
            ],
            [
                'nama'        => 'Wuling Air EV Long Range',
                'brand'       => 'Wuling',
                'harga'       => 275000000,
                'tahun'       => 2023,
                'transmisi'   => 'Matic',
                'bahan_bakar' => 'Listrik',
                'status'      => 'sold',
                'foto'        => 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?w=800&q=80',
            ],
            [
                'nama'        => 'Mazda 3 Hatchback 2.0 SKYACTIV-G',
                'brand'       => 'Mazda',
                'harga'       => 555000000,
                'tahun'       => 2022,
                'transmisi'   => 'Matic',
                'bahan_bakar' => 'Bensin',
                'status'      => 'tersedia',
                'foto'        => 'https://images.unsplash.com/photo-1580273916550-e323be2ae537?w=800&q=80',
            ],
            [
                'nama'        => 'Daihatsu Rocky 1.0 R Turbo CVT',
                'brand'       => 'Daihatsu',
                'harga'       => 245000000,
                'tahun'       => 2023,
                'transmisi'   => 'CVT',
                'bahan_bakar' => 'Bensin',
                'status'      => 'tersedia',
                'foto'        => 'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?w=800&q=80',
            ],
            [
                'nama'        => 'Honda CR-V 2.0 e:HEV RS',
                'brand'       => 'Honda',
                'harga'       => 805000000,
                'tahun'       => 2024,
                'transmisi'   => 'CVT',
                'bahan_bakar' => 'Hybrid',
                'status'      => 'sold',
                'foto'        => 'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?w=800&q=80',
            ],
            [
                'nama'        => 'Toyota Fortuner 2.8 GR Sport 4x4',
                'brand'       => 'Toyota',
                'harga'       => 735000000,
                'tahun'       => 2023,
                'transmisi'   => 'Matic',
                'bahan_bakar' => 'Diesel',
                'status'      => 'tersedia',
                'foto'        => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=800&q=80',
            ],
            [
                'nama'        => 'BYD Seal Performance AWD',
                'brand'       => 'BYD',
                'harga'       => 719000000,
                'tahun'       => 2024,
                'transmisi'   => 'Matic',
                'bahan_bakar' => 'Listrik',
                'status'      => 'tersedia',
                'foto'        => 'https://images.unsplash.com/photo-1502877338535-766e1452684a?w=800&q=80',
            ],
        ];
    }

    /**
     * Seed initial sample cars for a specific ruang / workspace.
     */
    public static function seedForRuang(string $ruang = 'public'): int
    {
        $cars = self::defaultCars();

        foreach ($cars as $data) {
            $data['ruang'] = $ruang;
            Mobil::updateOrCreate(
                [
                    'ruang' => $ruang,
                    'nama'  => $data['nama'],
                ],
                $data
            );
        }

        return count($cars);
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        self::seedForRuang('public');
    }
}
