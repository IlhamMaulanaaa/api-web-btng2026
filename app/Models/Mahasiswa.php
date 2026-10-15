<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $fillable = [
        'nama',
        'nim',
        'jurusan',
        'angkatan',
    ];

    protected $casts = [
        'angkatan' => 'integer',
    ];
}
