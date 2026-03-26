<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database (opsional jika namanya sudah 'testimonis')
     */
    protected $table = 'testimonis';

    /**
     * Kolom yang boleh diisi secara massal.
     * Sesuaikan dengan kolom yang ada di migrasi tadi.
     */
    protected $fillable = [
        'nama_pelanggan',
        'pesan',
        'bintang',
        'foto_pelanggan',
        'is_tampilkan',
    ];

    /**
     * Casting tipe data agar Laravel otomatis mengubahnya 
     * menjadi tipe data yang sesuai saat dipanggil.
     */
    protected $casts = [
        'is_tampilkan' => 'boolean',
        'bintang' => 'integer',
    ];

    /**
     * Helper: Jika ingin menampilkan bintang dalam bentuk teks/icon di tempat lain.
     */
    public function getBintangTeksAttribute(): string
    {
        return str_repeat('⭐', $this->bintang);
    }
}