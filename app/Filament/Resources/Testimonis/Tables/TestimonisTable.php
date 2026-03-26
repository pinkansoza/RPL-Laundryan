<?php

namespace App\Filament\Resources\Testimonis\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

class TestimonisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('foto_pelanggan')
                    ->label('Foto')
                    ->disk('public')
                    ->circular(),
                
                TextColumn::make('nama_pelanggan')
                    ->label('Nama Pelanggan')
                    ->searchable()
                    ->sortable()
                    ->size('sm'), 

                TextColumn::make('bintang')
                    ->label('Rating')
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', $state))
                    ->color('warning'),

                TextColumn::make('pesan')
                    ->label('Komentar')
                    ->limit(50)
                    ->wrap(),

                ToggleColumn::make('is_tampilkan')
                    ->label('Tampilkan di Web'),
            ])

            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}