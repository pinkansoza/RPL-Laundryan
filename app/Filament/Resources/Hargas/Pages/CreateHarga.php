<?php

namespace App\Filament\Resources\Hargas\Pages;

use App\Filament\Resources\Hargas\HargaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHarga extends CreateRecord
{
    protected static string $resource = HargaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('create');
        return $this->getResource()::getUrl('index');
    }
    
}
