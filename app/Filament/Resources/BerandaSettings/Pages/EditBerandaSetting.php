<?php

namespace App\Filament\Resources\BerandaSettings\Pages;

use App\Filament\Resources\BerandaSettings\BerandaSettingResource;
use Filament\Resources\Pages\EditRecord;

class EditBerandaSetting extends EditRecord
{
    protected static string $resource = BerandaSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getTitle(): string 
    {
        return 'Edit Pengaturan Beranda';
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}