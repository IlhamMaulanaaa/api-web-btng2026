<?php

use App\Http\Controllers\Api\MahasiswaController;
use App\Http\Controllers\Api\ResetController;
use Illuminate\Support\Facades\Route;

// Route pencarian langsung via format NIM (contoh: A11.2024.15656)
Route::get('mahasiswa/nim/{nim}', [MahasiswaController::class, 'showByNim'])
    ->where('nim', '[A-Z][0-9]{2}\.[0-9]{4}\.[0-9]{5}');

// Resource Routes untuk Mahasiswa
Route::apiResource('mahasiswa', MahasiswaController::class);

// Endpoint Reset Data (mendukung POST dan GET untuk kenyamanan pengajar saat kelas)
Route::match(['get', 'post'], '/reset', ResetController::class);

