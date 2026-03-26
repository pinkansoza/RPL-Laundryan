<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    use HasFactory;
    protected $table = 'testimonis';

    protected $fillable = [
        'nama_pelanggan',
        'pesan',
        'bintang',
        'foto_pelanggan',
        'is_tampilkan',
    ];

    protected $casts = [
        'is_tampilkan' => 'boolean',
        'bintang' => 'integer',
    ];

    public function getBintangTeksAttribute(): string
    {
        return str_repeat('⭐', $this->bintang);
    }
}