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
                    ->limit(30) // Biar nggak kepanjangan di tabel
                    ->searchable(),

                TextColumn::make('whatsapp')
                    ->label('WhatsApp')
                    ->icon('heroicon-m-phone') // Tambah ikon biar cakep
                    ->copyable() // Admin bisa langsung copy nomornya
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
                // Kosongkan saja karena datanya cuma sedikit (biasanya cuma 1)
            ])
            ->actions([
                EditAction::make(),
            ]);
    }
}