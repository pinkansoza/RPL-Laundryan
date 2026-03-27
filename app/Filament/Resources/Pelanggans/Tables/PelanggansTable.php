<?php

namespace App\Filament\Resources\Pelanggans\Tables;

use App\Models\Pelanggan;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;

class PelanggansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Pelanggan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->toggleable(),

                TextColumn::make('nomor_whatsapp')
                    ->label('WhatsApp')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-phone')
                    ->toggleable(),

                TextColumn::make('detail_alamat')
                    ->label('Alamat')
                    ->limit(30)
                    ->searchable()
                    ->toggleable(),

                // Kolom Koordinat Clickable (Biru + Underline)
                TextColumn::make('koordinat')
                    ->label('Titik Pickup')
                    ->getStateUsing(function (Pelanggan $record) {
                        if ($record->pickup_lat && $record->pickup_lng) {
                            return "{$record->pickup_lat}, {$record->pickup_lng}";
                        }
                        return '-';
                    })
                    ->icon('heroicon-m-map-pin')
                    ->color('primary')
                    ->url(fn (Pelanggan $record): ?string => 
                        $record->pickup_lat && $record->pickup_lng 
                            ? "https://www.google.com/maps/search/?api=1&query={$record->pickup_lat},{$record->pickup_lng}" 
                            : null
                    )
                    ->openUrlInNewTab()
                    ->extraAttributes([
                        'style' => 'text-decoration: underline; text-underline-offset: 4px;',
                    ])
                    ->toggleable(),

                // --- KOLOM TERDAFTAR SEJAK (KEMBALI LAGI) ---
                TextColumn::make('created_at')
                    ->label('Terdaftar Sejak')
                    ->dateTime('d M Y') // Format: 27 Mar 2026
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('dari_tanggal')->label('Pelanggan Sejak'),
                        DatePicker::make('sampai_tanggal')->label('Hingga'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['dari_tanggal'], fn ($query, $date) => $query->whereDate('created_at', '>=', $date))
                            ->when($data['sampai_tanggal'], fn ($query, $date) => $query->whereDate('created_at', '<=', $date));
                    })
            ])
            ->actions([
                EditAction::make()
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}