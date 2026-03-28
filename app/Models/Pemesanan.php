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

        // 1. Logika Membuat Kode Pesanan Otomatis
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

        // 2. Sinkronisasi ke Tabel Pelanggan
        static::saved(function ($model) {
            \App\Models\Pelanggan::updateOrCreate(
                ['nomor_whatsapp' => $model->nomor_whatsapp],
                [
                    'nama' => $model->nama_pelanggan,
                    'pickup_lat' => $model->pickup_lat,
                    'pickup_lng' => $model->pickup_lng,
                    'detail_alamat' => $model->detail_alamat,
                ]
            );
        });

        // 3. Otomatis Membuat Transaksi (Invoice) saat Pesanan Baru Dibuat
        static::created(function ($model) {
            $model->transaksi()->create([
                'kode_transaksi' => 'INV-' . $model->kode_pesanan, 
                'total_biaya' => $model->total_estimasi_harga,
                'total_akhir' => $model->total_estimasi_harga,
                'status_pembayaran' => 'Belum Lunas',
                'metode_pembayaran' => $model->metode_pembayaran,
            ]);
        });

        // 4. BARU: Otomatis Lunas saat Status Diubah jadi 'Diambil'
        static::updated(function ($model) {
            // Cek apakah kolom 'status' berubah DAN berubahnya ke 'Diambil'
            if ($model->isDirty('status') && $model->status === 'Diambil') {
                // Cari transaksi yang punya pemesanan_id ini, lalu update statusnya
                if ($model->transaksi) {
                    $model->transaksi->update([
                        'status_pembayaran' => 'Lunas',
                        // Tanggal bayar & bukti dikosongkan sesuai request Abang
                    ]);
                }
            }
        });
    }

    // Hubungan: Satu Pesanan punya Satu Transaksi
    public function transaksi()
    {
        return $this->hasOne(Transaksi::class);
    }
}