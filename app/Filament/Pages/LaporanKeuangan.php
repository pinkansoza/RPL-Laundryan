<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use App\Filament\Widgets\RekapPendapatan;
use App\Filament\Widgets\PendapatanChart;
use BackedEnum;
use UnitEnum;

class LaporanKeuangan extends Page implements HasForms
{
    use InteractsWithForms;
    use HasFiltersForm;

    protected static string|BackedEnum|null $navigationIcon = "heroicon-o-document-currency-dollar";
    protected static UnitEnum|string|null $navigationGroup = 'Keuangan';
    protected static ?string $navigationLabel = 'Laporan Pendapatan';
    protected static ?string $pluralModelLabel = 'Laporan Pendapatan';
    protected static ?string $title = 'Laporan Pendapatan Laundry';

    protected string $view = 'filament.pages.laporan-keuangan';

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Filter Rentang Laporan')
                    ->description('Pilih tanggal yang sama untuk laporan harian, atau rentang untuk mingguan/bulanan.')
                    ->schema([
                        DatePicker::make('startDate')
                            ->label('Dari Tanggal')
                            ->default(now()) // Default hari ini
                            ->required(),
                        DatePicker::make('endDate')
                            ->label('Sampai Tanggal')
                            ->default(now()) // Default hari ini
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    protected function getHeaderWidgets(): array
    {
        return [
            RekapPendapatan::class,
            PendapatanChart::class,
        ];
    }
}