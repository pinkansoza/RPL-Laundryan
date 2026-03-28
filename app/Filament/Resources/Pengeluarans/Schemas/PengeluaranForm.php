<?php

namespace App\Filament\Resources\Pengeluarans\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;

class PengeluaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Pengeluaran')
                    ->description('Catat pengeluaran operasional laundry di sini.')
                    ->schema([
                        TextInput::make('keterangan')
                            ->label('Keterangan / Nama Barang')
                            ->placeholder('Contoh: Beli Deterjen 10kg atau Bayar Listrik')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('nominal')
                            ->label('Nominal (Rp)')
                            ->numeric() // Memastikan hanya angka
                            ->prefix('Rp') // Tambah prefix mata uang
                            ->required()
                            ->minValue(0),

                        DatePicker::make('tanggal')
                            ->label('Tanggal Pengeluaran')
                            ->default(now()) // Otomatis isi tanggal hari ini
                            ->required()
                            ->native(false) // UI kalender lebih cantik
                            ->displayFormat('d/m/Y'),
                    ])
                    ->columns(1), // Dibuat satu kolom saja agar rapi di layar kecil
            ]);
    }
}