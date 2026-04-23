<?php

namespace App\Filament\Resources\Kontaks;

use App\Filament\Resources\Kontaks\Pages\EditKontak;
use App\Filament\Resources\Kontaks\Pages\ListKontaks;
use App\Filament\Resources\Kontaks\Schemas\KontakForm;
use App\Filament\Resources\Kontaks\Tables\KontaksTable;
use App\Models\Kontak;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model; 

class KontakResource extends Resource
{
    protected static ?string $model = Kontak::class;

    protected static string|BackedEnum|null $navigationIcon = "heroicon-o-phone"; 

    public static function getRecordTitle(?Model $record): \Illuminate\Contracts\Support\Htmlable|string|null
    {
        return 'Pengaturan Kontak';
    }

    protected static UnitEnum|string|null $navigationGroup = 'Pengaturan Website';
    
    protected static ?string $navigationLabel = 'Kontak';

    protected static ?string $pluralLabel = 'Kontak';

    protected static ?string $label = 'Kontak';
    
    protected static ?int $navigationSort = 4;

    public static function canAccess(): bool
    {
        return auth()->user()->role === 'owner';
    }

    public static function form(Schema $schema): Schema
    {
        return KontakForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KontaksTable::configure($table);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
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
            'index' => ListKontaks::route('/'),
            'edit' => EditKontak::route('/{record}/edit'),
        ];
    }
}