<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PemesananController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'wa' => 'required|string|max:20',
            'paket' => 'required|string',
            'layanan' => 'required|string',
            'berat' => 'nullable|numeric|min:0.1',
            'itemSatuan' => 'nullable|integer|min:1',
            'pengiriman' => 'required|string',
            // VALIDASI 'pengambilan' SUDAH DIHAPUS DARI SINI
            'jam' => 'nullable|string',
            'pembayaran' => 'required|string',
            'pickup_lat' => 'nullable|numeric',
            'pickup_lng' => 'nullable|numeric',
            'detail_alamat' => 'nullable|string',
            'catatan' => 'nullable|string|max:500',
            'total_estimasi' => 'required|integer',
        ]);

        $pesanan = Pemesanan::create([
            'nama_pelanggan' => $validated['nama'],
            'nomor_whatsapp' => $validated['wa'],
            'paket' => $validated['paket'],
            'jenis_layanan' => $validated['layanan'],
            'berat' => $validated['berat'] ?? null,
            'jumlah_item' => $validated['itemSatuan'] ?? null,
            'total_estimasi_harga' => $validated['total_estimasi'],
            'metode_pembayaran' => $validated['pembayaran'],
            'metode_pengiriman' => $validated['pengiriman'],
            
            // NILAI DEFAULT OTOMATIS SAAT PELANGGAN ORDER
            'metode_pengambilan' => 'Ambil Sendiri', 
            
            'jam_pickup' => $validated['jam'] ?? null,
            'pickup_lat' => $validated['pickup_lat'] ?? null,
            'pickup_lng' => $validated['pickup_lng'] ?? null,
            'detail_alamat' => $validated['detail_alamat'] ?? null,
            'catatan' => $validated['catatan'] ?? null,
            'status' => 'Diterima',
        ]);

        return redirect()->back()
            ->with('success', 'Pesanan kamu berhasil dibuat!')
            ->with('kode_pesanan', $pesanan->kode_pesanan);
    }
}