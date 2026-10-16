<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Database\Seeders\MahasiswaSeeder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResetController extends Controller
{
    /**
     * Reset table mahasiswa back to original seeded records for a specific workspace.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $ruang = $request->route('ruang');
        $ruang = !empty($ruang) ? trim((string) $ruang) : 'public';

        // Delete records belonging to this workspace only
        Mahasiswa::where('ruang', $ruang)->delete();

        // Seed 11 sample records for this workspace
        $count = MahasiswaSeeder::seedForRuang($ruang);

        return response()->json([
            'success' => true,
            'message' => "Database ruang '{$ruang}' berhasil di-reset ke data awal ({$count} data mahasiswa seeder).",
            'ruang'   => $ruang,
            'total'   => $count,
        ], 200);
    }
}
