<?php

namespace App\Http\Controllers;

use App\Models\BerandaSetting;
use App\Models\Layanan;
use App\Models\Harga;
use App\Models\Kontak;
use App\Models\Testimoni;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        $beranda = BerandaSetting::first();
        $layanans = Layanan::orderBy('urutan', 'asc')->get();
        $hargas = Harga::orderBy('nama_paket', 'asc')->get();
        $kontak = Kontak::first();
        
        // Parse prices for Alpine.js order form
        $parsedPrices = [];
        foreach ($hargas as $harga) {
            $parsedPrices[$harga->nama_paket] = [];
            $konten = is_string($harga->konten) ? json_decode($harga->konten, true) : $harga->konten;
            if (is_array($konten)) {
                foreach ($konten as $kategori) {
                    if (isset($kategori['items'])) {
                        foreach ($kategori['items'] as $item) {
                            $namaItem = $item['nama_item'] ?? '';
                            $hargaLabel = $item['harga_label'] ?? '';
                            // Extract numbers only
                            $hargaInt = (int) preg_replace('/[^0-9]/', '', $hargaLabel);
                            $parsedPrices[$harga->nama_paket][$namaItem] = $hargaInt;
                        }
                    }
                }
            }
        }
        
        // Handle Tracking Order
        $trackingResult = null;
        if ($request->filled('kode')) {
            $trackingResult = Pemesanan::where('kode_pesanan', $request->kode)->first();
        }

        $testimonis = Testimoni::where('is_tampilkan', true)->latest()->get();
        return view('welcome', compact('beranda', 'layanans', 'hargas', 'kontak', 'testimonis', 'parsedPrices', 'trackingResult'));
    }
}