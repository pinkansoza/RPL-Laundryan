<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    // Tentukan kolom mana saja yang boleh diisi secara massal
    protected $fillable = [
        'nama',
        'deskripsi',
        'ikon',
        'warna',
        'urutan',
    ];

    // Opsional: Jika kamu ingin memastikan urutan default selalu 0
    protected $attributes = [
        'urutan' => 0,
    ];
}