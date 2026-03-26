<?php

namespace App\Filament\Resources\BerandaSettings\Pages;

use App\Filament\Resources\BerandaSettings\BerandaSettingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBerandaSetting extends CreateRecord
{
    protected static string $resource = BerandaSettingResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}