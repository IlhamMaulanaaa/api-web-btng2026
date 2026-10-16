<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Default dataset for students.
     */
    public static function defaultStudents(): array
    {
        return [
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
    }

    /**
     * Seed initial sample data for a specific ruang / workspace.
     */
    public static function seedForRuang(string $ruang = 'public'): int
    {
        $students = self::defaultStudents();

        foreach ($students as $data) {
            $data['ruang'] = $ruang;
            Mahasiswa::updateOrCreate(
                [
                    'ruang' => $ruang,
                    'nim'   => $data['nim'],
                ],
                $data
            );
        }

        return count($students);
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        self::seedForRuang('public');
    }
}
