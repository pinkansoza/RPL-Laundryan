<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    use HasFactory;

    // Nama tabelnya (opsional jika sudah jamak 'kontaks', tapi aman buat jaga-jaga)
    protected $table = 'kontaks';

    // Daftar kolom yang boleh diisi lewat form/admin
    protected $fillable = [
        'alamat',
        'whatsapp',
        'instagram',
        'jam_operasional',
        'url_gmaps',
    ];
}