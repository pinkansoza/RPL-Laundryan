<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'pemesanan_id', 
        'kode_transaksi', 
        'total_biaya', 
        'total_akhir', 
        'status_pembayaran', 
        'metode_pembayaran', 
        'bukti_pembayaran', 
        'tgl_bayar'
    ];

    // Hubungan: Transaksi ini miliknya siapa? (Milik satu Pesanan)
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }
}