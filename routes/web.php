<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;

Route::get('/', [LandingPageController::class, 'index'])->name('home');

Route::get('/offline', function () {
    return view('offline');
});

Route::get('/offline-profile', function () {
    return view('offline-profile');
});

Route::get('/cetak-nota/{transaksi}', function (\App\Models\Transaksi $transaksi) {
    $kontak = \App\Models\Kontak::first();
    return view('transaksi.nota-thermal', compact('transaksi', 'kontak'));
})->name('cetak.nota')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/laporan/pdf', function (\Illuminate\Http\Request $request) {
        $dari = $request->dari ?? now()->startOfMonth()->format('Y-m-d');
        $sampai = $request->sampai ?? now()->endOfMonth()->format('Y-m-d');

        $transaksis = \App\Models\Transaksi::with('pemesanan')
            ->where('status_pembayaran', 'Lunas')
            ->whereDate('created_at', '>=', $dari)
            ->whereDate('created_at', '<=', $sampai)
            ->get();

        $pengeluarans = \App\Models\Pengeluaran::whereDate('tanggal', '>=', $dari)
            ->whereDate('tanggal', '<=', $sampai)
            ->get();

        $pemasukan = $transaksis->sum('total_akhir');
        $pengeluaran = $pengeluarans->sum('nominal');
        $bersih = $pemasukan - $pengeluaran;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.pdf', compact(
            'transaksis', 'pengeluarans', 'pemasukan', 'pengeluaran', 'bersih', 'dari', 'sampai'
        ));

        return $pdf->stream('laporan-keuangan-' . $dari . '-sd-' . $sampai . '.pdf');
    })->name('laporan.pdf');

    Route::get('/laporan/csv', function (\Illuminate\Http\Request $request) {
        $dari = $request->dari ?? now()->startOfMonth()->format('Y-m-d');
        $sampai = $request->sampai ?? now()->endOfMonth()->format('Y-m-d');

        $transaksis = \App\Models\Transaksi::with('pemesanan')
            ->where('status_pembayaran', 'Lunas')
            ->whereDate('created_at', '>=', $dari)
            ->whereDate('created_at', '<=', $sampai)
            ->get();

        $pengeluarans = \App\Models\Pengeluaran::whereDate('tanggal', '>=', $dari)
            ->whereDate('tanggal', '<=', $sampai)
            ->get();

        $pemasukan = $transaksis->sum('total_akhir');
        $pengeluaran = $pengeluarans->sum('nominal');
        $bersih = $pemasukan - $pengeluaran;

        $callback = function() use ($transaksis, $pengeluarans, $pemasukan, $pengeluaran, $bersih) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ['LAPORAN KEUANGAN LAUNDRY']);
            fputcsv($file, ['']);
            
            fputcsv($file, ['RINCIAN PEMASUKAN']);
            fputcsv($file, ['Tanggal', 'No Invoice', 'Pelanggan', 'Nominal']);
            foreach ($transaksis as $t) {
                $tgl = $t->tgl_bayar ? \Carbon\Carbon::parse($t->tgl_bayar)->format('d/m/Y') : $t->created_at->format('d/m/Y');
                fputcsv($file, [$tgl, $t->kode_transaksi, $t->pemesanan ? $t->pemesanan->nama_pelanggan : 'Pesanan Dihapus', $t->total_akhir]);
            }
            fputcsv($file, ['Total Pemasukan', '', '', $pemasukan]);
            
            fputcsv($file, ['']);
            
            fputcsv($file, ['RINCIAN PENGELUARAN']);
            fputcsv($file, ['Tanggal', 'Keterangan', '', 'Nominal']);
            foreach ($pengeluarans as $p) {
                fputcsv($file, [\Carbon\Carbon::parse($p->tanggal)->format('d/m/Y'), $p->keterangan, '', $p->nominal]);
            }
            fputcsv($file, ['Total Pengeluaran', '', '', $pengeluaran]);
            
            fputcsv($file, ['']);
            fputcsv($file, ['PENDAPATAN BERSIH', '', '', $bersih]);
            
            fclose($file);
        };

        return response()->stream($callback, 200, [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=laporan-keuangan-{$dari}-sd-{$sampai}.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ]);
    })->name('laporan.csv');
});