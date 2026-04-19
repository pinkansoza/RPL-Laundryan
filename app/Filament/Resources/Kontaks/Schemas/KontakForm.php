<?php

namespace App\Filament\Resources\Kontaks\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class KontakForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kontak')
                    ->description('Masukkan detail kontak yang akan tampil di footer website.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('tiktok')
                                    ->label('Username TikTok')
                                    ->placeholder('laundry.ak')
                                    ->prefix('@'),

                                TextInput::make('whatsapp')
                                    ->label('Nomor WhatsApp')
                                    ->placeholder('628816514122')
                                    ->helperText('Gunakan angka saja, diawali 62 (Contoh: 628123...)')
                                    ->required(),

                                TextInput::make('instagram')
                                    ->label('Username Instagram')
                                    ->placeholder('laundry.ak')
                                    ->prefix('@'),

                                TextInput::make('jam_operasional')
                                    ->label('Jam Operasional')
                                    ->placeholder('Setiap Hari: 07.00 - 21.00 WIB')
                                    ->required(),
                            ]),
                    ]),

                Section::make('Lokasi Peta')
                    ->description('Copy-paste link "src" dari embed Google Maps.')
                    ->schema([
                        Textarea::make('url_gmaps')
                            ->label('URL Iframe Maps (src)')
                            ->placeholder('https://www.google.com/maps/embed?pb=...')
                            ->rows(3)
                            ->required()
                            ->helperText('Ambil hanya isi di dalam tanda kutip src="..." pada menu Bagikan > Sematkan Peta.'),
                    ]),
            ]);
    }
}