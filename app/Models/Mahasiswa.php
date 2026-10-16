<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $fillable = [
        'ruang',
        'nama',
        'nim',
        'jurusan',
        'angkatan',
    ];

    protected $attributes = [
        'ruang' => 'public',
    ];

    protected $casts = [
        'angkatan' => 'integer',
    ];

    /**
     * Scope query to a specific student workspace / ruang.
     */
    public function scopeRuang($query, ?string $ruang = null)
    {
        $target = !empty($ruang) ? $ruang : 'public';
        return $query->where('ruang', $target);
    }
}
