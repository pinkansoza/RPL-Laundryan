<?php

namespace App\Http\Controllers;

use App\Models\BerandaSetting;
use App\Models\Layanan;
use App\Models\Harga;
use App\Models\Kontak;
use App\Models\Testimoni;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $beranda = BerandaSetting::first();
        $layanans = Layanan::orderBy('urutan', 'asc')->get();
        $hargas = Harga::orderBy('nama_paket', 'asc')->get();
        $kontak = Kontak::first();
        $testimonis = Testimoni::where('is_tampilkan', true)->latest()->get();
        return view('welcome', compact('beranda', 'layanans', 'hargas', 'kontak', 'testimonis'));
    }
}