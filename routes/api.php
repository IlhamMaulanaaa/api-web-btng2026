<?php

use App\Http\Controllers\Api\MahasiswaController;
use App\Http\Controllers\Api\ResetController;
use Illuminate\Support\Facades\Route;

// 1. Default Public Workspace (Backward compatibility for legacy /api/mahasiswa calls)
Route::get('mahasiswa/nim/{nim}', [MahasiswaController::class, 'showByNim'])
    ->where('nim', '[A-Z][0-9]{2}\.[0-9]{4}\.[0-9]{5}');
Route::apiResource('mahasiswa', MahasiswaController::class);
Route::match(['get', 'post'], '/reset', ResetController::class);

// 2. Student Multi-Tenant Workspace Isolation (/api/{ruang}/mahasiswa)
Route::prefix('{ruang}')
    ->where(['ruang' => '^(?!mahasiswa$|reset$|docs$)[a-zA-Z0-9_\-\.]+$'])
    ->group(function () {
        Route::get('mahasiswa/nim/{nim}', [MahasiswaController::class, 'showByNim'])
            ->where('nim', '[A-Z][0-9]{2}\.[0-9]{4}\.[0-9]{5}');
        Route::apiResource('mahasiswa', MahasiswaController::class);
        Route::match(['get', 'post'], 'reset', ResetController::class);
    });
