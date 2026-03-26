<?php

namespace App\Filament\Resources\Pemesanans\Pages;

use App\Filament\Resources\Pemesanans\PemesananResource;
use App\Models\Pemesanan;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListPemesanans extends ListRecords
{
    protected static string $resource = PemesananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'Semua' => Tab::make('Semua Pesanan')
                ->badge(Pemesanan::count()),
            'Pickup' => Tab::make('Kurir Pickup')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('metode_pengiriman', 'Pickup'))
                ->badge(Pemesanan::where('metode_pengiriman', 'Pickup')->count())
                ->badgeColor('primary'),
            'Antar' => Tab::make('Antar Sendiri')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('metode_pengiriman', 'Antar Sendiri'))
                ->badge(Pemesanan::where('metode_pengiriman', 'Antar Sendiri')->count())
                ->badgeColor('success'),
        ];
    }
}
