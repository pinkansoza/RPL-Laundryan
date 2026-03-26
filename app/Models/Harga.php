<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Harga extends Model
{
    protected $fillable = ['nama_paket', 'estimasi', 'konten'];

    protected $casts = [
        'konten' => 'array', // WAJIB: Biar Filament bisa simpan data berjenjang
    ];
}