<?php

namespace App\Filament\Resources\BerandaSettings\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\EditAction; 

class BerandaSettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('gambar')
                    ->label('Gambar Utama')
                    ->disk('public')
                    ->circular(),

                TextColumn::make('judul')
                    ->label('Judul Beranda')
                    ->wrap()
                    ->html()
                    ->searchable(),

                TextColumn::make('slogan')
                    ->label('Slogan')
                    ->limit(50)
                    ->color('gray'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Sekarang EditAction sudah dikenali karena import-nya benar
                EditAction::make(),
            ])
            ->bulkActions([
                // Kosongkan agar fitur hapus massal hilang
            ]);
    }
}