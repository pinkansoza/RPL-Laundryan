<?php

namespace App\Filament\Resources\Hargas\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

class HargasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_paket')
                    ->label('Nama Paket')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('estimasi')
                    ->label('Estimasi'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Dibuat Pada')
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}