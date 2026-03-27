<?php

namespace App\Filament\Widgets;

use App\Models\Pelanggan;
use App\Models\Pemesanan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CustomerStats extends BaseWidget
{
    // Supaya kotak statistiknya muncul paling atas, sebelum tabel/chart lain
    protected static ?int $sort = -1;

    protected function getStats(): array
    {
        return [
            // Kotak 1: Total Pelanggan
            Stat::make('Total Pelanggan', Pelanggan::count())
                ->description('Database pelanggan setia')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'), 

            // Kotak 2: Pesanan yang belum disentuh
            Stat::make('Pesanan Baru', Pemesanan::where('status', 'Diterima')->count())
                ->description('Perlu segera dicuci')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('warning'),

            // Kotak 3: Total Omset (Duit Masuk)
            Stat::make('Estimasi Omset', 'Rp ' . number_format(Pemesanan::sum('total_estimasi_harga'), 0, ',', '.'))
                ->description('Total pendapatan kotor')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}