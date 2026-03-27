<?php

namespace App\Filament\Resources\Pelanggans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Dotswan\MapPicker\Fields\Map;
use Filament\Schemas\Schema;

class PelangganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Nama Pelanggan')
                    ->required()
                    ->maxLength(255),
                    
                TextInput::make('nomor_whatsapp')
                    ->label('Nomor WhatsApp')
                    ->required()
                    ->unique(ignoreRecord: true) // Mencegah duplikat WA
                    ->maxLength(255),
                    
                Textarea::make('detail_alamat')
                    ->label('Detail Alamat Rumah')
                    ->columnSpanFull(),

                Map::make('titik_pickup')
                    ->label('Titik Lokasi Rumah (Untuk Pickup/Antar)')
                    ->columnSpanFull()
                    ->defaultLocation(latitude: -6.200000, longitude: 106.816666)
                    ->afterStateHydrated(function ($state, $record, callable $set) {
                        if ($record && $record->pickup_lat && $record->pickup_lng) {
                            $set('titik_pickup', ['lat' => $record->pickup_lat, 'lng' => $record->pickup_lng]);
                        }
                    })
                    ->afterStateUpdated(function ($state, callable $set) {
                        if (is_array($state)) {
                            $set('pickup_lat', $state['lat'] ?? null);
                            $set('pickup_lng', $state['lng'] ?? null);
                        }
                    })
                    ->live(onBlur: true)
                    ->showMarker(true)
                    ->draggable(true)
                    ->clickable(true)
                    ->showFullscreenControl(true)
                    ->showZoomControl(true)
                    ->showMyLocationButton(true),

                Hidden::make('pickup_lat'),
                Hidden::make('pickup_lng'),
            ]);
    }
}