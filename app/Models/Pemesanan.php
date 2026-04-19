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
        'foto',
        'status',
    ];

    protected $casts = [
        'foto' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        // 1. Logika Membuat Kode Pesanan Otomatis
        static::creating(function ($model) {
            if (empty($model->kode_pesanan)) {
                // Tentukan kode prefix layanan
                $kodeLayanan = ($model->paket === 'Laundry Kiloan') ? '0407' : '0704';
                $tanggal = now()->format('dmY'); // Format: 19042026
                $prefix = "{$kodeLayanan}.{$tanggal}.";

                // Cari nomor urut terbesar dari tabel pemesanans dan transaksis (karena transaksi tidak dihapus saat pesanan dihapus)
                $latestOrder = static::where('kode_pesanan', 'like', $prefix . '%')->orderBy('kode_pesanan', 'desc')->first();
                $latestTransaksi = \App\Models\Transaksi::where('kode_transaksi', 'like', $prefix . '%')->orderBy('kode_transaksi', 'desc')->first();

                $maxNumber = 0;

                if ($latestOrder) {
                    $parts = explode('.', $latestOrder->kode_pesanan);
                    if (count($parts) === 3) {
                        $num = intval($parts[2]);
                        if ($num > $maxNumber) $maxNumber = $num;
                    }
                }

                if ($latestTransaksi) {
                    $parts = explode('.', $latestTransaksi->kode_transaksi);
                    if (count($parts) === 3) {
                        $num = intval($parts[2]);
                        if ($num > $maxNumber) $maxNumber = $num;
                    }
                }

                $nextNumber = $maxNumber + 1;
                $model->kode_pesanan = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
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
                'kode_transaksi' => $model->kode_pesanan, 
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