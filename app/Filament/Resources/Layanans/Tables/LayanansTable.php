<?php

namespace App\Filament\Resources\Layanans\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class LayanansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Layanan')
                    ->searchable(),

                TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(50),

                TextColumn::make('ikon')
                    ->label('Ikon')
                    ->badge(),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
            ]);
    }
}
