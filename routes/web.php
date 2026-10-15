<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('docs');
});

Route::get('/docs', function () {
    return view('docs');
});

// Alias rute untuk Dokumentasi Scramble API
Route::get('/scramble', function () {
    return redirect('/docs/api');
});

Route::get('/reference', function () {
    return redirect('/docs/api');
});

Route::get('/scalar', function () {
    return redirect('/docs/api');
});
