<?php

namespace App\Filament\Resources\Hargas\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HargaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Header Paket')
                    ->description('Tentukan nama paket utama dan estimasi waktunya.')
                    ->schema([
                        TextInput::make('nama_paket')
                            ->label('Nama Paket')
                            ->placeholder('Contoh: REGULER')
                            ->required(),
                        TextInput::make('estimasi')
                            ->label('Label Estimasi')
                            ->placeholder('Contoh: 2-3 Hari Pengerjaan')
                            ->required(),
                    ])->columns(2),

                // REPEATER LEVEL 1: KATEGORI (e.g., Cuci Kiloan)
                Repeater::make('konten')
                    ->label('Daftar Kategori & Layanan')
                    ->addActionLabel('Tambah Kategori Baru')
                    ->schema([
                        TextInput::make('nama_kategori')
                            ->label('Nama Kategori')
                            ->placeholder('Contoh: Cuci Kiloan')
                            ->required(),

                        // REPEATER LEVEL 2: ITEM (e.g., Cuci Kering Setrika)
                        Repeater::make('items')
                            ->label('Daftar Item/Layanan di Kategori Ini')
                            ->addActionLabel('Tambah Item & Harga')
                            ->schema([
                                TextInput::make('nama_item')
                                    ->label('Nama Layanan')
                                    ->placeholder('Contoh: Cuci Kering Setrika')
                                    ->required(),
                                TextInput::make('harga_label')
                                    ->label('Harga & Satuan')
                                    ->placeholder('Contoh: Rp 6.000/kg')
                                    ->required(),
                            ])
                            ->columns(2) 
                    ])
                    ->itemLabel(fn (array $state): ?string => $state['nama_kategori'] ?? 'Kategori Baru')
                    ->collapsible(), // Biar bisa diringkas kalau sudah banyak
            ]);
    }
}