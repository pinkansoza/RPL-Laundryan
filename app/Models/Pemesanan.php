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
        'durasi_layanan',
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

            // Kirim Notifikasi WA (Background Request)
            $pesan = "Halo Kak *{$model->nama_pelanggan}* 👋\n\nTerima kasih sudah mempercayakan cuciannya di *Laundry AK*!\nNomor Struk: *{$model->kode_pesanan}*\nLayanan: {$model->paket} - {$model->jenis_layanan}\n\nCucian kakak sedang kami proses masuk mesin cuci hari ini. Tunggu info selanjutnya kalau sudah wangi ya!\n\n~ Sistem Otomatis Laundry AK ~";
            try {
                \Illuminate\Support\Facades\Http::timeout(3)->post('http://localhost:3000/api/send-message', [
                    'number' => $model->nomor_whatsapp,
                    'message' => $pesan
                ]);
            } catch (\Exception $e) {}
        });

        // 4. Logika Perubahan Status (Diambil jadi Lunas & Selesai Kirim WA)
        static::updated(function ($model) {
            // Cek apakah kolom 'status' berubah
            if ($model->isDirty('status')) {

                if ($model->status === 'Diambil') {
                    // Update jadi lunas di transaksi
                    if ($model->transaksi) {
                        $model->transaksi->update([
                            'status_pembayaran' => 'Lunas',
                        ]);
                    }
                }

                if ($model->status === 'Selesai') {
                    // Kirim Notifikasi WA Cucian Kelar
                    $total = "Rp " . number_format($model->transaksi->total_akhir ?? $model->total_estimasi_harga, 0, ',', '.');
                    $pesanSelesai = "PING!! 🔔\n\nHalo Kak *{$model->nama_pelanggan}*, cucian baju kakak dengan Struk *{$model->kode_pesanan}* saat ini sudah SELESAI, terlipat rapi, dan pastinya super wangi!\n\nSilakan datang ke outlet untuk pengambilan ya kak.\nTotal Tagihan: *$total*\n\nTerima kasih banyak! 🙏";

                    try {
                        \Illuminate\Support\Facades\Http::timeout(3)->post('http://localhost:3000/api/send-message', [
                            'number' => $model->nomor_whatsapp,
                            'message' => $pesanSelesai
                        ]);
                    } catch (\Exception $e) {}
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