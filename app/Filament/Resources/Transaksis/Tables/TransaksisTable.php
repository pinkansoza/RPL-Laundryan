<?php

namespace App\Filament\Resources\Transaksis\Tables;

use App\Models\Kontak;
use Filament\Tables\Table;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkAction;
use Filament\Forms\Components\Select;
use Filament\Actions\BulkActionGroup;
use Illuminate\Support\Facades\Response;

class TransaksisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_transaksi')
                    ->label('Invoice')
                    ->fontFamily('mono')
                    ->color('primary')
                    ->searchable()
                    ->copyable()
                    ->sortable(),

                TextColumn::make('pemesanan.nama_pelanggan')
                    ->label('Pelanggan')
                    ->default('Pesanan Dihapus')
                    ->searchable(),

                TextColumn::make('total_akhir')
                    ->label('Nominal')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('status_pembayaran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Lunas' => 'success',
                        'Belum Lunas' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('metode_pembayaran')
                    ->label('Metode'),

                TextColumn::make('tgl_bayar')
                    ->label('Tgl Bayar')
                    ->dateTime('d/m/Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                EditAction::make(),

                // CETAK STRUK THERMAL via Browser Print
                Action::make('print')
                    ->label('Cetak Nota')
                    ->icon('heroicon-m-printer')
                    ->color('info')
                    ->url(fn ($record) => route('cetak.nota', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('ubahMetodePembayaran')
                        ->label('Ubah Metode Pembayaran')
                        ->icon('heroicon-o-credit-card')
                        ->form([
                            Select::make('metode_pembayaran')
                                ->label('Pilih Metode')
                                ->options([
                                    'Cash' => 'Cash',
                                    'QRIS' => 'QRIS',
                                ])
                                ->required(),
                        ])
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records, array $data): void {
                            foreach ($records as $record) {
                                // Update tabel transaksis
                                $record->update([
                                    'metode_pembayaran' => $data['metode_pembayaran'],
                                ]);
                                
                                // Jika ingin sinkronisasi ke tabel pemesanans (opsional, karena relasinya ada)
                                if ($record->pemesanan) {
                                    $record->pemesanan->update([
                                        'metode_pembayaran' => $data['metode_pembayaran'],
                                    ]);
                                }
                            }
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}
