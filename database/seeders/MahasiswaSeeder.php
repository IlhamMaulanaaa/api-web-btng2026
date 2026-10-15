<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mahasiswas = [
            [
                'nama' => 'Ilham Pratama',
                'nim' => 'A11.2024.15656',
                'jurusan' => 'Teknik Informatika',
                'angkatan' => 2024,
            ],
            [
                'nama' => 'Budi Santoso',
                'nim' => 'A11.2023.14001',
                'jurusan' => 'Teknik Informatika',
                'angkatan' => 2023,
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'nim' => 'A11.2023.14002',
                'jurusan' => 'Teknik Informatika',
                'angkatan' => 2023,
            ],
            [
                'nama' => 'Ahmad Fauzi',
                'nim' => 'A12.2022.13015',
                'jurusan' => 'Sistem Informasi',
                'angkatan' => 2022,
            ],
            [
                'nama' => 'Dewi Lestari',
                'nim' => 'A12.2022.13020',
                'jurusan' => 'Sistem Informasi',
                'angkatan' => 2022,
            ],
            [
                'nama' => 'Rizky Pratama',
                'nim' => 'A14.2024.15003',
                'jurusan' => 'Desain Komunikasi Visual',
                'angkatan' => 2024,
            ],
            [
                'nama' => 'Nabila Putri',
                'nim' => 'A14.2024.15012',
                'jurusan' => 'Desain Komunikasi Visual',
                'angkatan' => 2024,
            ],
            [
                'nama' => 'Fajar Hidayat',
                'nim' => 'B11.2023.11045',
                'jurusan' => 'Manajemen',
                'angkatan' => 2023,
            ],
            [
                'nama' => 'Anisa Rahmawati',
                'nim' => 'B12.2023.12008',
                'jurusan' => 'Akuntansi',
                'angkatan' => 2023,
            ],
            [
                'nama' => 'Bayu Wicaksono',
                'nim' => 'C11.2021.09050',
                'jurusan' => 'Ilmu Komunikasi',
                'angkatan' => 2021,
            ],
            [
                'nama' => 'Clarissa Aurelia',
                'nim' => 'A11.2024.15501',
                'jurusan' => 'Teknik Informatika',
                'angkatan' => 2024,
            ],
        ];

        foreach ($mahasiswas as $data) {
            Mahasiswa::updateOrCreate(
                ['nim' => $data['nim']],
                $data
            );
        }
    }
}
