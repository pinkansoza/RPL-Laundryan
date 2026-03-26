<?php

namespace App\Filament\Resources\BerandaSettings\Pages;

use App\Filament\Resources\BerandaSettings\BerandaSettingResource;
use Filament\Resources\Pages\ListRecords;

class ListBerandaSettings extends ListRecords
{
    protected static string $resource = BerandaSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}