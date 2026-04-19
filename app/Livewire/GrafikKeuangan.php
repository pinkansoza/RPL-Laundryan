<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;

class GrafikKeuangan extends ChartWidget
{
    protected ?string $heading = 'Grafik Arus Kas Harian';
    public ?string $dari = null;
    public ?string $sampai = null;

    protected function getData(): array
    {
        $start = $this->dari ? \Illuminate\Support\Carbon::parse($this->dari) : now()->startOfMonth();
        $end = $this->sampai ? \Illuminate\Support\Carbon::parse($this->sampai) : now()->endOfMonth();

        $pemasukanData = [];
        $pengeluaranData = [];
        $bersihData = [];
        $labels = [];

        // Loop through each day
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $dateString = $date->format('Y-m-d');
            $labels[] = $date->format('d M');

            $in = \App\Models\Transaksi::where('status_pembayaran', 'Lunas')
                ->whereDate('created_at', $dateString)
                ->sum('total_akhir');

            $out = \App\Models\Pengeluaran::whereDate('tanggal', $dateString)
                ->sum('nominal');

            $pemasukanData[] = $in;
            $pengeluaranData[] = $out;
            $bersihData[] = $in - $out;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Uang Masuk',
                    'data' => $pemasukanData,
                    'borderColor' => '#16a34a',
                    'backgroundColor' => 'rgba(22, 163, 74, 0.2)',
                ],
                [
                    'label' => 'Uang Keluar',
                    'data' => $pengeluaranData,
                    'borderColor' => '#dc2626',
                    'backgroundColor' => 'rgba(220, 38, 38, 0.2)',
                ],
                [
                    'label' => 'Uang Bersih',
                    'data' => $bersihData,
                    'borderColor' => '#2563eb',
                    'backgroundColor' => 'rgba(37, 99, 235, 0.2)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
