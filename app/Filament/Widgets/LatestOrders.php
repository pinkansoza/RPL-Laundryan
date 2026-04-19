<?php

namespace App\Filament\Widgets;

use App\Models\Pemesanan;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;

class LatestOrders extends BaseWidget
{
    protected static ?int $sort = 2;
    
    // Rentangkan tabel lebar penuh layar
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Pemesanan::whereIn('status', ['Diterima', 'Dicuci', 'Selesai'])
                    ->latest()
                    ->limit(5)
            )
            ->heading('Cucian Mendesak / Sedang Aktif')
            ->description('Daftar 5 Cucian terakhir yang belum diambil pelanggan.')
            ->columns([
                TextColumn::make('kode_pesanan')
                    ->label('Invoice')
                    ->searchable()
                    ->badge()
                    ->color('primary'),

                TextColumn::make('nama_pelanggan')
                    ->label('Pelanggan'),

                TextColumn::make('paket')
                    ->label('Paket')
                    ->badge(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Diterima' => 'danger',
                        'Dicuci' => 'warning',
                        'Selesai' => 'success',
                        'Diambil' => 'gray',
                        default => 'primary',
                    }),
                    
                TextColumn::make('created_at')
                    ->label('Tanggal Order')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Action::make('buka')
                    ->label('Buka')
                    ->icon('heroicon-m-arrow-top-right-on-square')
                    ->url(fn (Pemesanan $record): string => route('filament.bakulTambakSukses.resources.pemesanans.edit', $record)),
            ]);
    }
}
