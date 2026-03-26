<?php

namespace App\Filament\Resources\Kontaks\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class KontaksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('alamat')
                    ->label('Alamat')
                    ->limit(30) 
                    ->searchable(),

                TextColumn::make('whatsapp')
                    ->label('WhatsApp')
                    ->icon('heroicon-m-phone') 
                    ->copyable() 
                    ->searchable(),

                TextColumn::make('instagram')
                    ->label('Instagram')
                    ->formatStateUsing(fn (?string $state): string => $state ? "@{$state}" : '-')
                    ->badge()
                    ->color('info')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('jam_operasional')
                    ->label('Jam Operasional'),
            ])
            ->filters([
            ])
            ->actions([
                EditAction::make(),
            ]);
    }
}