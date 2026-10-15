<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Database\Seeders\MahasiswaSeeder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Schema;

class ResetController extends Controller
{
    /**
     * Reset table mahasiswa back to original 10 seeded records.
     */
    public function __invoke(): JsonResponse
    {
        Schema::disableForeignKeyConstraints();
        Mahasiswa::truncate();
        Schema::enableForeignKeyConstraints();

        $seeder = new MahasiswaSeeder();
        $seeder->run();

        $count = Mahasiswa::count();

        return response()->json([
            'success' => true,
            'message' => "Database berhasil di-reset ke data awal ({$count} data mahasiswa seeder).",
            'total'   => $count,
        ], 200);
    }
}
