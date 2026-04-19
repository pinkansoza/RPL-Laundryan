<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Carbon;
use App\Models\Transaksi;
use App\Models\Pengeluaran;
use Filament\Actions\Action;
use BackedEnum;
use UnitEnum;

class LaporanKeuangan extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.laporan-keuangan';

    protected static UnitEnum|string|null $navigationGroup = 'Keuangan';
    
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-chart-bar';
    
    protected static ?int $navigationSort = 4;

    protected static ?string $title = 'Laporan Keuangan';

    public static function canAccess(): bool
    {
        return auth()->user()->role === 'owner';
    }

    public ?string $dari_tanggal = null;
    public ?string $sampai_tanggal = null;

    public function mount()
    {
        $this->dari_tanggal = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->sampai_tanggal = Carbon::now()->endOfMonth()->format('Y-m-d');
        
        $this->form->fill([
            'dari_tanggal' => $this->dari_tanggal,
            'sampai_tanggal' => $this->sampai_tanggal,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Filter Periode Laporan')
                    ->schema([
                        DatePicker::make('dari_tanggal')
                            ->label('Dari Tanggal')
                            ->live()
                            ->afterStateUpdated(fn ($state) => $this->dari_tanggal = $state)
                            ->required(),
                        DatePicker::make('sampai_tanggal')
                            ->label('Sampai Tanggal')
                            ->live()
                            ->afterStateUpdated(fn ($state) => $this->sampai_tanggal = $state)
                            ->required(),
                    ])->columns(2),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('cetak_pdf')
                ->label('Download PDF')
                ->icon('heroicon-o-document-text')
                ->color('danger')
                ->url(fn () => route('laporan.pdf', ['dari' => $this->dari_tanggal, 'sampai' => $this->sampai_tanggal]))
                ->openUrlInNewTab(),
            
            Action::make('cetak_excel')
                ->label('Download CSV')
                ->icon('heroicon-o-table-cells')
                ->color('success')
                ->url(fn () => route('laporan.csv', ['dari' => $this->dari_tanggal, 'sampai' => $this->sampai_tanggal]))
                ->openUrlInNewTab(),
        ];
    }

    protected function getViewData(): array
    {
        $dari = $this->dari_tanggal ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $sampai = $this->sampai_tanggal ?? Carbon::now()->endOfMonth()->format('Y-m-d');

        // Pemasukan: Hanya pesanan lunas
        $pemasukan = Transaksi::where('status_pembayaran', 'Lunas')
            ->whereDate('created_at', '>=', $dari)
            ->whereDate('created_at', '<=', $sampai)
            ->sum('total_akhir');

        // Pengeluaran
        $pengeluaran = \App\Models\Pengeluaran::whereDate('tanggal', '>=', $dari)
            ->whereDate('tanggal', '<=', $sampai)
            ->sum('nominal');

        $bersih = $pemasukan - $pengeluaran;

        return [
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'bersih' => $bersih,
        ];
    }
}
