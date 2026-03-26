<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'ikon',
        'warna',
        'urutan',
    ];
    protected $attributes = [
        'urutan' => 0,
    ];
}