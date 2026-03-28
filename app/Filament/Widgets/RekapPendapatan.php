<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use App\Models\Pengeluaran; // IMPORT MODEL PENGELUARAN
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Carbon;

class RekapPendapatan extends BaseWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        // 1. Ambil filter tanggal secara aman (Null Safety)
        $filters = $this->filters ?? [];

        $start = ($filters['startDate'] ?? null) 
            ? Carbon::parse($filters['startDate'])->startOfDay() 
            : now()->startOfDay();

        $end = ($filters['endDate'] ?? null) 
            ? Carbon::parse($filters['endDate'])->endOfDay() 
            : now()->endOfDay();

        // 2. HITUNG PEMASUKAN (Dari Transaksi yang Lunas)
        $totalPemasukan = Transaksi::where('status_pembayaran', 'Lunas')
            ->whereBetween('updated_at', [$start, $end])
            ->sum('total_akhir');

        // 3. HITUNG PENGELUARAN (Dari Tabel Pengeluaran)
        // Kita pakai kolom 'tanggal' yang ada di tabel pengeluarans
        $totalPengeluaran = Pengeluaran::whereBetween('tanggal', [$start, $end])
            ->sum('nominal');

        // 4. HITUNG UANG BERSIH
        $uangBersih = $totalPemasukan - $totalPengeluaran;

        // 5. Label dinamis buat keterangan waktu
        $tglInfo = ($start->format('Y-m-d') === $end->format('Y-m-d')) 
            ? "Hari ini (" . $start->format('d M Y') . ")"
            : $start->format('d M') . " - " . $end->format('d M Y');

        return [
            // Kartu Pemasukan
            Stat::make('Total Pemasukan', 'Rp ' . number_format($totalPemasukan, 0, ',', '.'))
                ->description('Duit masuk: ' . $tglInfo)
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            // Kartu Pengeluaran
            Stat::make('Total Pengeluaran', 'Rp ' . number_format($totalPengeluaran, 0, ',', '.'))
                ->description('Biaya operasional: ' . $tglInfo)
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),

            // Kartu Uang Bersih (Profit)
            Stat::make('Uang Bersih (Net Profit)', 'Rp ' . number_format($uangBersih, 0, ',', '.'))
                ->description('Keuntungan bersih setelah potong biaya')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color($uangBersih >= 0 ? 'info' : 'danger'), // Biru kalau untung, merah kalau rugi
        ];
    }
}