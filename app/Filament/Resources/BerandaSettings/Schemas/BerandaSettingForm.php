<?php

namespace App\Filament\Resources\BerandaSettings\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;

class BerandaSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Konten Beranda')
                    ->description('Atur tampilan utama halaman depan di sini.')
                    ->schema([
                        TextInput::make('judul')
                            ->label('Judul Beranda')
                            ->required()
                            ->placeholder('Contoh: Solusi Cerdas untuk <br> <span>Pakaian Berkualitas</span>')
                            ->helperText('Gunakan <br> untuk baris baru dan <span> untuk teks biru.'),

                        Textarea::make('slogan')
                            ->label('Slogan / Deskripsi')
                            ->required()
                            ->rows(3)
                            ->helperText('Gunakan <span class="text-[#89b252]">teks</span> untuk warna hijau atau <br> untuk baris baru.'),

                        FileUpload::make('gambar')
                            ->label('Gambar Utama')
                            ->image()
                            ->disk('public')
                            ->directory('beranda') 
                            ->imageEditor()
                            ->required()
                            ->helperText('Unggah gambar pengganti 6.png (Format: PNG/JPG).'),
                    ])
            ]);
    }
}