<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PendapatanChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Grafik Aliran Kas';
    protected string $color = 'info';

    protected function getData(): array
{
    // 1. Ambil filter secara aman. Kalau null, ganti jadi array kosong.
    $filters = $this->filters ?? [];

    // 2. GUNAKAN variabel $filters (tanpa 'this->'), 
    // dan tambahkan pengaman '?? null'
    $start = ($filters['startDate'] ?? null) 
        ? Carbon::parse($filters['startDate'])->startOfDay() 
        : now()->startOfDay();

    $end = ($filters['endDate'] ?? null) 
        ? Carbon::parse($filters['endDate'])->endOfDay() 
        : now()->endOfDay();

    // 3. Query Database
    $data = Transaksi::select(
            DB::raw('DATE(updated_at) as date'),
            DB::raw('SUM(total_akhir) as total')
        )
        ->where('status_pembayaran', 'Lunas')
        ->whereBetween('updated_at', [$start, $end])
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    return [
        'datasets' => [
            [
                'label' => 'Uang Masuk (Rp)',
                'data' => $data->pluck('total')->toArray(),
                'fill' => 'start',
                'tension' => 0.4,
            ],
        ],
        'labels' => $data->pluck('date')->map(fn ($date) => Carbon::parse($date)->format('d M'))->toArray(),
    ];
}

    protected function getType(): string
    {
        return 'line';
    }
}