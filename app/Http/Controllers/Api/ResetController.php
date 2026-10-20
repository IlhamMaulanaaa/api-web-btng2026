<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Mobil;
use Database\Seeders\MahasiswaSeeder;
use Database\Seeders\MobilSeeder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResetController extends Controller
{
    /**
     * Reset table mobil (and mahasiswa) back to original seeded records for a specific workspace.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $ruang = $request->route('ruang');
        $ruang = !empty($ruang) ? trim((string) $ruang) : 'public';

        // 1. Reset tabel mobil ke 12 data seeder mobil
        Mobil::where('ruang', $ruang)->delete();
        $countMobil = MobilSeeder::seedForRuang($ruang);

        // 2. Reset tabel mahasiswa untuk backward compatibility
        $countMhs = 0;
        if (class_exists(Mahasiswa::class)) {
            Mahasiswa::where('ruang', $ruang)->delete();
            $countMhs = MahasiswaSeeder::seedForRuang($ruang);
        }

        return response()->json([
            'success'     => true,
            'message'     => "Database showroom ruang '{$ruang}' berhasil di-reset ke data awal ({$countMobil} unit mobil seeder).",
            'ruang'       => $ruang,
            'total'       => $countMhs ?: $countMobil,
            'total_mobil' => $countMobil,
        ], 200);
    }
}
