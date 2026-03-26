<?php

namespace App\Filament\Resources\Pemesanans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PemesanansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_pesanan')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary')
                    ->copyable(),
                TextColumn::make('nama_pelanggan')
                    ->searchable(),
                TextColumn::make('nomor_whatsapp')
                    ->searchable(),
                TextColumn::make('paket')
                    ->searchable(),
                TextColumn::make('jenis_layanan')
                    ->searchable(),
                TextColumn::make('berat')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('jumlah_item')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_estimasi_harga')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                TextColumn::make('metode_pembayaran')
                    ->searchable(),
                TextColumn::make('metode_pengiriman')
                    ->searchable(),
                TextColumn::make('jam_pickup')
                    ->searchable(),
                TextColumn::make('pickup_lat')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('pickup_lng')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Diterima' => 'info',
                        'Dicuci' => 'warning',
                        'Selesai' => 'success',
                        'Diambil' => 'success',
                        'Dibatalkan' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('catatan')
                    ->searchable()
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
