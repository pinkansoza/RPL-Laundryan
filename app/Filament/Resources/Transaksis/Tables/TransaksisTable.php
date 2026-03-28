<?php

namespace App\Filament\Resources\Transaksis\Tables;

use App\Models\Kontak;
use Filament\Tables\Table;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
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
                    ->searchable(),

                TextColumn::make('total_akhir')
                    ->label('Nominal')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('status_pembayaran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Lunas' => 'success',
                        'DP' => 'warning',
                        'Belum Lunas' => 'danger',
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

                // HANYA TOMBOL CETAK STRUK THERMAL
                Action::make('print')
                    ->label('Cetak Nota')
                    ->icon('heroicon-m-printer')
                    ->color('info')
                    ->action(function ($record) {
                        $kontak = Kontak::first();
                        
                        $pdf = Pdf::loadView('transaksi.nota', [
                            'transaksi' => $record,
                            'kontak' => $kontak,
                        ]);

                        // Setting Kertas Thermal 58mm
                        $pdf->setPaper([0, 0, 164.41, 500], 'portrait'); 

                        return Response::streamDownload(function () use ($pdf) {
                            echo $pdf->stream();
                        }, "Struk-{$record->kode_transaksi}.pdf");
                    }),
            ]);
    }
}