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
                    ->label('Invoice')
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
                \Filament\Actions\Action::make('cetak_nota')
                    ->label('Cetak')
                    ->icon('heroicon-m-printer')
                    ->color('info')
                    ->url(fn ($record) => $record->transaksi ? route('cetak.nota', $record->transaksi) : null)
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => $record->transaksi !== null),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    \Filament\Actions\BulkAction::make('ubah_ke_dicuci')
                        ->label('Tandai Dicuci')
                        ->icon('heroicon-o-beaker')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->modalHeading('Ubah Status ke Dicuci')
                        ->modalDescription('Apakah Anda yakin ingin mengubah status pesanan yang dipilih menjadi "Dicuci"?')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $records->each->update(['status' => 'Dicuci']);
                            \Filament\Notifications\Notification::make()
                                ->title($records->count() . ' pesanan diubah ke Dicuci')
                                ->success()
                                ->send();
                        }),

                    \Filament\Actions\BulkAction::make('ubah_ke_selesai')
                        ->label('Tandai Selesai')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Ubah Status ke Selesai')
                        ->modalDescription('Apakah Anda yakin ingin mengubah status pesanan yang dipilih menjadi "Selesai"?')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $records->each->update(['status' => 'Selesai']);
                            \Filament\Notifications\Notification::make()
                                ->title($records->count() . ' pesanan diubah ke Selesai')
                                ->success()
                                ->send();
                        }),

                    \Filament\Actions\BulkAction::make('ubah_ke_diambil')
                        ->label('Tandai Diambil')
                        ->icon('heroicon-o-hand-raised')
                        ->color('info')
                        ->requiresConfirmation()
                        ->modalHeading('Ubah Status ke Diambil')
                        ->modalDescription('Apakah Anda yakin ingin mengubah status pesanan yang dipilih menjadi "Diambil"? Transaksi akan otomatis menjadi Lunas.')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $records->each->update(['status' => 'Diambil']);
                            \Filament\Notifications\Notification::make()
                                ->title($records->count() . ' pesanan diubah ke Diambil & Lunas')
                                ->success()
                                ->send();
                        }),

                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}