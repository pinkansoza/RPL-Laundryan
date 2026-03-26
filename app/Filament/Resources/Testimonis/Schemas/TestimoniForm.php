<?php

namespace App\Filament\Resources\Testimonis\Schemas;

use Filament\Schemas\Schema; // Tetap pakai ini sesuai Resource
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;

class TestimoniForm
{
    // Namanya disamakan dengan panggilan di Resource: 'configure'
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Testimoni')
                    ->schema([
                        TextInput::make('nama_pelanggan')
                            ->required()
                            ->placeholder('Contoh: Budi Santoso'),
                        
                        Select::make('bintang')
                            ->options([
                                5 => '⭐⭐⭐⭐⭐ (Sangat Puas)',
                                4 => '⭐⭐⭐⭐ (Puas)',
                                3 => '⭐⭐⭐ (Cukup)',
                            ])
                            ->default(5)
                            ->required(),

                        Textarea::make('pesan')
                            ->label('Isi Testimoni')
                            ->required()
                            ->rows(3),

                        FileUpload::make('foto_pelanggan')
                            ->image()
                            ->disk('public')
                            ->directory('testimoni'),

                        Toggle::make('is_tampilkan')
                            ->label('Tampilkan di Website')
                            ->default(true),
                    ])
            ]);
    }
}