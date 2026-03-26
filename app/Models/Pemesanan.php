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
    }
}
