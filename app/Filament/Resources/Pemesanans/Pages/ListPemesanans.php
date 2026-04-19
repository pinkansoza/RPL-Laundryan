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
            'Diterima' => Tab::make('Diterima')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'Diterima'))
                ->badge(Pemesanan::where('status', 'Diterima')->count())
                ->badgeColor('info'),
            'Dicuci' => Tab::make('Dicuci')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'Dicuci'))
                ->badge(Pemesanan::where('status', 'Dicuci')->count())
                ->badgeColor('warning'),
            'Selesai' => Tab::make('Selesai')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'Selesai'))
                ->badge(Pemesanan::where('status', 'Selesai')->count())
                ->badgeColor('success'),
            'Diambil' => Tab::make('Diambil')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'Diambil'))
                ->badge(Pemesanan::where('status', 'Diambil')->count())
                ->badgeColor('gray'),
        ];
    }
}
