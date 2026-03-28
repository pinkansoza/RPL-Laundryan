<?php

namespace App\Filament\Resources\Pengeluarans;

use App\Filament\Resources\Pengeluarans\Pages\CreatePengeluaran;
use App\Filament\Resources\Pengeluarans\Pages\EditPengeluaran;
use App\Filament\Resources\Pengeluarans\Pages\ListPengeluarans;
use App\Filament\Resources\Pengeluarans\Schemas\PengeluaranForm;
use App\Filament\Resources\Pengeluarans\Tables\PengeluaransTable;
use App\Models\Pengeluaran;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PengeluaranResource extends Resource
{
    protected static ?string $model = Pengeluaran::class;

    protected static string|BackedEnum|null $navigationIcon ="heroicon-o-clipboard-document";

    protected static ?string $recordTitleAttribute = 'pengeluaran';

    protected static UnitEnum|string|null $navigationGroup = 'Keuangan';

    protected static ?string $navigationLabel = 'Data Pengeluaran';

    protected static ?string $pluralModelLabel = 'Pengeluaran';

    protected static ?string $title = 'Pengeluaran';

    public static function form(Schema $schema): Schema
    {
        return PengeluaranForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PengeluaransTable::configure($table);
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
            'index' => ListPengeluarans::route('/'),
            'create' => CreatePengeluaran::route('/create'),
            'edit' => EditPengeluaran::route('/{record}/edit'),
        ];
    }
}
