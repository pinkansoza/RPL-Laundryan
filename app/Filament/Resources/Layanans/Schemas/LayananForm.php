<?php

namespace App\Filament\Resources\Layanans\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;

class LayananForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Layanan')
                    ->description('Detail layanan yang akan muncul di kotak beranda.')
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Layanan')
                            ->placeholder('Contoh: Cuci Komplit')
                            ->required(),

                        Textarea::make('deskripsi')
                            ->label('Deskripsi Singkat')
                            ->placeholder('Contoh: Cuci, kering, dan setrika rapi.')
                            ->rows(2)
                            ->required(),

                        TextInput::make('ikon')
                            ->label('Nama Ikon (Heroicons)')
                            ->placeholder('Contoh: heroicon-o-sparkles')
                            ->helperText('Cari nama ikon di heroicons.com (format: heroicon-o-namaikon)')
                            ->required(),

                        Select::make('warna')
                            ->label('Warna Background Ikon')
                            ->options([
                                'bg-blue-400' => 'Biru',
                                'bg-green-400' => 'Hijau',
                                'bg-purple-400' => 'Ungu',
                                'bg-orange-400' => 'Oranye',
                                'bg-rose-400' => 'Merah Muda',
                            ])
                            ->required(),
                    ])
            ]);
    }
}