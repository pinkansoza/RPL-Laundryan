<?php

namespace App\Filament\Widgets;

use App\Models\Pemesanan;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class TipeLayananChart extends ChartWidget
{
    protected static ?int $sort = 3;
    protected ?string $heading = 'Tipe Layanan Terfavorit (Bulan Ini)';
    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Cari tahu jumlah per paket secara dinamis
        $dataPaket = Pemesanan::selectRaw('paket, count(*) as total')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->groupBy('paket')
            ->get();

        $labels = [];
        $data = [];
        $colors = [
            '#3b82f6', // blue
            '#10b981', // emerald
            '#f59e0b', // amber
            '#ef4444', // red
            '#6366f1', // indigo
        ];
        
        $backgroundColors = [];

        foreach ($dataPaket as $index => $item) {
            $labels[] = $item->paket ?? 'Tanpa Paket';
            $data[] = $item->total;
            // Gunakan modulo agar tidak error kalau paketnya sangat banyak
            $backgroundColors[] = $colors[$index % count($colors)];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Pesanan',
                    'data' => $data,
                    'backgroundColor' => $backgroundColors,
                    'hoverOffset' => 4
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        // Bisa pakai 'pie' atau 'doughnut'
        return 'doughnut';
    }
}
