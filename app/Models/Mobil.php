<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;

    protected $fillable = [
        'ruang',
        'nama',
        'brand',
        'harga',
        'tahun',
        'transmisi',
        'bahan_bakar',
        'status',
        'foto',
    ];

    protected $attributes = [
        'ruang'  => 'public',
        'status' => 'tersedia',
    ];

    protected $casts = [
        'harga' => 'integer',
        'tahun' => 'integer',
    ];

    /**
     * Scope query ke workspace / ruang tertentu.
     */
    public function scopeRuang($query, ?string $ruang = null)
    {
        $target = !empty($ruang) ? $ruang : 'public';
        return $query->where('ruang', $target);
    }

    /**
     * Scope query filter brand.
     */
    public function scopeBrand($query, ?string $brand = null)
    {
        if (!empty($brand)) {
            return $query->where('brand', $brand);
        }
        return $query;
    }

    /**
     * Scope query filter status ketersediaan unit.
     */
    public function scopeStatus($query, ?string $status = null)
    {
        if (!empty($status)) {
            return $query->where('status', $status);
        }
        return $query;
    }
}
