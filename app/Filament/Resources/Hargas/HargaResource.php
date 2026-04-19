<?php

namespace App\Filament\Resources\Hargas;

use App\Filament\Resources\Hargas\Pages\CreateHarga;
use App\Filament\Resources\Hargas\Pages\EditHarga;
use App\Filament\Resources\Hargas\Pages\ListHargas;
use App\Filament\Resources\Hargas\Schemas\HargaForm;
use App\Filament\Resources\Hargas\Tables\HargasTable;
use App\Models\Harga;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HargaResource extends Resource
{
    protected static ?string $model = Harga::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $recordTitleAttribute = 'harga';

    protected static UnitEnum|string|null $navigationGroup = 'Pengaturan Website';
    
    protected static ?string $navigationLabel = 'Harga';

    protected static ?string $pluralLabel = 'Harga';

    protected static ?string $label = 'Harga';
    
    protected static ?int $navigationSort = 3;

    public static function canAccess(): bool
    {
        return auth()->user()->role === 'owner';
    }

    public static function form(Schema $schema): Schema
    {
        return HargaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HargasTable::configure($table);
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
            'index' => ListHargas::route('/'),
            'create' => CreateHarga::route('/create'),
            'edit' => EditHarga::route('/{record}/edit'),
        ];
    }
}
