<?php

namespace App\Filament\Resources\BerandaSettings\Pages;

use App\Filament\Resources\BerandaSettings\BerandaSettingResource;
use Filament\Resources\Pages\ListRecords;
// Hapus import CreateAction jika tidak dipakai lagi

class ListBerandaSettings extends ListRecords
{
    protected static string $resource = BerandaSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Kosongkan array ini agar tombol "New" di pojok kanan atas hilang
        ];
    }
}