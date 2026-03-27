<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nomor_whatsapp',
        'pickup_lat',
        'pickup_lng',
        'detail_alamat',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            // Mengambil nomor WA lama sebelum diupdate untuk mencari data di tabel Pemesanan
            $oldWa = $model->getOriginal('nomor_whatsapp') ?? $model->nomor_whatsapp;

            // List status pesanan yang masih berjalan (belum diambil/selesai total)
            $statusAktif = ['Diterima', 'Dicuci', 'Selesai'];

            \App\Models\Pemesanan::where('nomor_whatsapp', $oldWa)
                ->whereIn('status', $statusAktif) // <-- Filter sakti agar riwayat lama aman
                ->update([
                    'nama_pelanggan' => $model->nama,
                    'nomor_whatsapp' => $model->nomor_whatsapp,
                    'pickup_lat'     => $model->pickup_lat,
                    'pickup_lng'     => $model->pickup_lng,
                    'detail_alamat'  => $model->detail_alamat,
                ]);
        });
    }
}