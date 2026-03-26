<?php

namespace App\Filament\Resources\Pemesanans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PemesananForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode_pesanan')
                    ->disabled()
                    ->dehydrated(false)
                    ->placeholder('Otomatis LDR-XXXXX')
                    ->maxLength(255),
                TextInput::make('nama_pelanggan')
                    ->required(),
                TextInput::make('nomor_whatsapp')
                    ->required(),
                TextInput::make('paket')
                    ->required(),
                TextInput::make('jenis_layanan')
                    ->required(),
                TextInput::make('berat')
                    ->numeric()
                    ->default(null),
                TextInput::make('jumlah_item')
                    ->numeric()
                    ->default(null),
                TextInput::make('total_estimasi_harga')
                    ->required()
                    ->numeric(),
                TextInput::make('metode_pembayaran')
                    ->required(),
                TextInput::make('metode_pengiriman')
                    ->required(),
                TextInput::make('jam_pickup')
                    ->default(null),
                TextInput::make('pickup_lat')
                    ->numeric()
                    ->default(null),
                TextInput::make('pickup_lng')
                    ->numeric()
                    ->default(null),
                Textarea::make('detail_alamat')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('catatan')
                    ->default(null)
                    ->columnSpanFull(),
                \Filament\Forms\Components\Select::make('status')
                    ->options([
                        'Diterima' => 'Diterima',
                        'Dicuci' => 'Dicuci',
                        'Selesai' => 'Selesai',
                        'Diambil' => 'Diambil',
                        'Dibatalkan' => 'Dibatalkan',
                    ])
                    ->required()
                    ->default('Diterima'),
            ]);
    }
}
