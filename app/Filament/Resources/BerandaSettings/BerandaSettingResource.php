<?php

namespace App\Filament\Resources\BerandaSettings;

use App\Filament\Resources\BerandaSettings\Pages\CreateBerandaSetting;
use App\Filament\Resources\BerandaSettings\Pages\EditBerandaSetting;
use App\Filament\Resources\BerandaSettings\Pages\ListBerandaSettings;
use App\Filament\Resources\BerandaSettings\Schemas\BerandaSettingForm;
use App\Filament\Resources\BerandaSettings\Tables\BerandaSettingsTable;
use App\Models\BerandaSetting;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
// WAJIB IMPORT KEDUANYA UNTUK MENGHINDARI FATAL ERROR TIPE DATA
use UnitEnum;
use BackedEnum;

class BerandaSettingResource extends Resource
{
    protected static ?string $model = BerandaSetting::class;

    // Perbaikan: Gunakan deklarasi tipe lengkap sesuai core Filament
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'judul';

    // Perbaikan: Tambahkan UnitEnum agar match dengan parent class
    protected static UnitEnum|string|null $navigationGroup = 'Pengaturan Website';
    
    protected static ?string $navigationLabel = 'Beranda';

    protected static ?string $pluralLabel = 'Beranda';
    
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return BerandaSettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BerandaSettingsTable::configure($table);
    }

    /**
     * Trik Khusus Pengaturan: 
     * Sembunyikan tombol "Create" jika sudah ada 1 data di database.
     */
    public static function canCreate(): bool
    {
        return BerandaSetting::count() < 1;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBerandaSettings::route('/'),
            'create' => CreateBerandaSetting::route('/create'),
            'edit' => EditBerandaSetting::route('/{record}/edit'),
        ];
    }
}