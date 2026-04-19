<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use App\Models\Pengeluaran;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PemasukanBulananChart extends ChartWidget
{
    protected static ?int $sort = 4;
    protected ?string $heading = 'Grafik Arus Kas (Tahun Ini)';
    protected ?string $maxHeight = '300px';

    public static function canView(): bool
    {
        return auth()->user()->role === 'owner';
    }

    protected function getData(): array
    {
        $currentYear = Carbon::now()->year;
        
        $pemasukanData = [];
        $pengeluaranData = [];
        $labels = [];

        // Loop array bulan 1 s/d 12
        for ($month = 1; $month <= 12; $month++) {
            $monthName = Carbon::create()->month($month)->translatedFormat('M');
            $labels[] = $monthName;

            // Pemasukan
            $in = Transaksi::where('status_pembayaran', 'Lunas')
                ->whereYear('updated_at', $currentYear)
                ->whereMonth('updated_at', $month)
                ->sum('total_akhir');

            // Pengeluaran
            $out = Pengeluaran::whereYear('tanggal', $currentYear)
                ->whereMonth('tanggal', $month)
                ->sum('nominal');

            $pemasukanData[] = $in;
            $pengeluaranData[] = $out;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Uang Masuk',
                    'data' => $pemasukanData,
                    'backgroundColor' => 'rgba(22, 163, 74, 0.8)', // hijau
                ],
                [
                    'label' => 'Uang Keluar',
                    'data' => $pengeluaranData,
                    'backgroundColor' => 'rgba(220, 38, 38, 0.8)', // merah
                ]
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        // Pakai Bar Chart untuk komparasi bulanan
        return 'bar';
    }
}
