<?php

namespace App\Filament\Widgets;

use App\Models\Pemesanan;
use App\Models\Transaksi;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class DashboardStats extends BaseWidget
{
    protected static ?int $sort = 1;

    // Refresh secara otomatis setiap 60 detik
    protected ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        $today = Carbon::today();

        // 1. Antrean Menunggu Diambil (Status = Selesai)
        $menungguDiambil = Pemesanan::where('status', 'Selesai')->count();

        // 2. Cucian Sedang Diproses (Diterima / Dicuci)
        $sedangDiproses = Pemesanan::whereIn('status', ['Diterima', 'Dicuci'])->count();
        
        // 3. Pesanan Masuk Hari Ini
        $pesananBaru = Pemesanan::whereDate('created_at', $today)->count();

        $stats = [
            Stat::make('Siap Diambil', $menungguDiambil . ' Pesanan')
                ->description('Cucian selesai & belum dipickup')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Sedang Diproses', $sedangDiproses . ' Pesanan')
                ->description('Cucian aktif (Diterima/Dicuci)')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('warning'),

            Stat::make('Order Masuk Harian', $pesananBaru . ' Order')
                ->description('Jumlah cucian datang hari ini')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('info'),
        ];

        // Khusus Owner: Tambahkan widget Omset
        if (auth()->check() && auth()->user()->role === 'owner') {
            $pemasukanHariIni = Transaksi::where('status_pembayaran', 'Lunas')
                ->whereDate('updated_at', $today)
                ->sum('total_akhir');

            $stats[] = Stat::make('Omset Hari Ini', 'Rp ' . number_format($pemasukanHariIni, 0, ',', '.'))
                ->description('Pemasukan uang Cash & QRIS')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary');
        }

        return $stats;
    }
}
