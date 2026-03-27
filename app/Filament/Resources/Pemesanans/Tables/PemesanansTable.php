<?php

namespace App\Filament\Resources\Pemesanans\Tables;

use App\Models\Pemesanan;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;

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
                    ->copyable()
                    ->toggleable(),
                TextColumn::make('nama_pelanggan')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('nomor_whatsapp')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('paket')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('jenis_layanan')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('berat')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('jumlah_item')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('total_estimasi_harga')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('metode_pembayaran')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('metode_pengiriman')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('jam_pickup')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('titik_pickup')
                    ->label('Titik Pickup')
                    ->getStateUsing(function (Pemesanan $record) {
                        if ($record->pickup_lat && $record->pickup_lng) {
                            return "{$record->pickup_lat}, {$record->pickup_lng}";
                        }
                        return '-';
                    })
                    ->url(fn (Pemesanan $record) => $record->pickup_lat && $record->pickup_lng ? "https://www.google.com/maps/search/?api=1&query={$record->pickup_lat},{$record->pickup_lng}" : null)
                    ->openUrlInNewTab()
                    ->icon('heroicon-m-map-pin')
                    ->toggleable(isToggledHiddenByDefault: true),
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
                    })
                    ->toggleable(),
                TextColumn::make('catatan')
                    ->searchable()
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Tanggal Order')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label('Tanggal Update')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Filter::make('tanggal')
                    ->label('Filter Tanggal')
                    ->form([
                        DatePicker::make('tanggal_order')
                            ->label('Tanggal Order'),
                        DatePicker::make('tanggal_selesai')
                            ->label('Tanggal Selesai'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['tanggal_order'], fn (Builder $q, $date) => $q->whereDate('created_at', $date))
                            ->when($data['tanggal_selesai'], fn (Builder $q, $date) => $q->whereDate('updated_at', $date));
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['tanggal_order'] ?? null) $indicators[] = 'Order: ' . \Carbon\Carbon::parse($data['tanggal_order'])->translatedFormat('d M Y');
                        if ($data['tanggal_selesai'] ?? null) $indicators[] = 'Selesai: ' . \Carbon\Carbon::parse($data['tanggal_selesai'])->translatedFormat('d M Y');
                        return $indicators;
                    }),

                SelectFilter::make('jenis_layanan')
                    ->label('Jenis Layanan')
                    ->options(fn () => Pemesanan::query()->distinct()->pluck('jenis_layanan', 'jenis_layanan')->toArray())
                    ->searchable(),

                SelectFilter::make('paket')
                    ->label('Paket')
                    ->options(fn () => Pemesanan::query()->distinct()->pluck('paket', 'paket')->toArray()),

                SelectFilter::make('metode_pengiriman')
                    ->label('Pengiriman')
                    ->options([
                        'Antar Sendiri - Ambil Sendiri' => 'Antar Sendiri - Ambil Sendiri',
                        'Antar Sendiri - Diantar Laundry' => 'Antar Sendiri - Diantar Laundry',
                        'Pickup Laundry - Ambil Sendiri' => 'Pickup Laundry - Ambil Sendiri',
                        'Pickup Laundry - Diantar Laundry' => 'Pickup Laundry - Diantar Laundry',
                    ]),

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'Diterima' => 'Diterima',
                        'Dicuci' => 'Dicuci',
                        'Selesai' => 'Selesai',
                        'Diambil' => 'Diambil',
                        'Dibatalkan' => 'Dibatalkan',
                    ]),
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
