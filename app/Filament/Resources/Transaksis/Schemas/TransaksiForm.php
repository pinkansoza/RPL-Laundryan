<?php

namespace App\Filament\Resources\Transaksis\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Schema;

class TransaksiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode_transaksi')
                    ->disabled()
                    ->label('Nomor Invoice'),

                Select::make('status_pembayaran')
                    ->options([
                        'Belum Lunas' => 'Belum Lunas',
                        'DP' => 'DP (Down Payment)',
                        'Lunas' => 'Lunas',
                    ])
                    ->required()
                    ->native(false),

                Select::make('metode_pembayaran')
                    ->options([
                        'Cash' => 'Cash',
                        'QRIS' => 'QRIS',
                        'Transfer' => 'Transfer Bank',
                    ])
                    ->native(false),

                TextInput::make('total_akhir')
                    ->label('Total yang Harus Dibayar')
                    ->numeric()
                    ->prefix('Rp')
                    ->disabled(),

                FileUpload::make('bukti_pembayaran')
                    ->image()
                    ->directory('bukti-bayar')
                    ->columnSpanFull(),

                DateTimePicker::make('tgl_bayar')
                    ->label('Tanggal Pelunasan')
                    ->default(now()),
            ]);
    }
}