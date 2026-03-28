<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal.
     * Penting agar tidak kena error 'Add [kolom] to fillable' saat simpan data.
     */
    protected $fillable = [
        'keterangan',
        'nominal',
        'tanggal',
    ];

    /**
     * Casting tipe data.
     * Kita paksa 'tanggal' jadi objek Carbon agar di Widget/Laporan nanti
     * kita bisa manipulasi tanggalnya dengan mudah (format, diff, dll).
     */
    protected $casts = [
        'tanggal' => 'date',
    ];
}