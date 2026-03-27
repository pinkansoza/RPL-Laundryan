<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanans';

    protected $fillable = [
        'kode_pesanan',
        'nama_pelanggan',
        'nomor_whatsapp',
        'paket',
        'jenis_layanan',
        'berat',
        'jumlah_item',
        'total_estimasi_harga',
        'metode_pembayaran',
        'metode_pengiriman',
        'metode_pengambilan',
        'jam_pickup',
        'pickup_lat',
        'pickup_lng',
        'detail_alamat',
        'catatan',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        // 1. Logika Membuat Kode Pesanan Otomatis (Tetap Seperti Milikmu)
        static::creating(function ($model) {
            if (empty($model->kode_pesanan)) {
                $latestOrder = static::orderBy('kode_pesanan', 'desc')->first();
                $nextNumber = 1;
                if ($latestOrder && preg_match('/LDR-(\d+)/', $latestOrder->kode_pesanan, $matches)) {
                    $nextNumber = intval($matches[1]) + 1;
                }
                $model->kode_pesanan = 'LDR-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            }
        });

        // 2. Logika Update/Simpan ke Tabel Pelanggan Otomatis
        static::saved(function ($model) {
            // Kita gunakan updateOrCreate agar jika nomor WA sudah ada, datanya diupdate.
            // Jika belum ada, maka akan dibuatkan baris baru.
            \App\Models\Pelanggan::updateOrCreate(
                ['nomor_whatsapp' => $model->nomor_whatsapp], // Kunci pencarian
                [
                    'nama' => $model->nama_pelanggan,
                    'pickup_lat' => $model->pickup_lat,
                    'pickup_lng' => $model->pickup_lng,
                    'detail_alamat' => $model->detail_alamat,
                ]
            );
        });
    }
}