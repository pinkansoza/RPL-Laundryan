<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BerandaSetting extends Model
{
    // Menentukan field mana saja yang boleh diisi lewat form
    protected $fillable = [
        'judul',
        'slogan',
        'gambar',
    ];

    /**
     * Tips: Jika ingin menghapus file fisik di storage saat data diupdate,
     * kamu bisa menambahkan logic observer di sini. 
     * Tapi untuk level dasar, ini sudah cukup.
     */
}