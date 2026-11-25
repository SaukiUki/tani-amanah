<?php

declare(strict_types=1);

namespace App\Filament\Resources\SalamContracts;

use App\Filament\Resources\SalamContracts\Pages\CreateSalamContract;
use App\Filament\Resources\SalamContracts\Pages\EditSalamContract;
use App\Filament\Resources\SalamContracts\Pages\ListSalamContracts;
use App\Filament\Resources\SalamContracts\Schemas\SalamContractForm;
use App\Filament\Resources\SalamContracts\Tables\SalamContractsTable;
use App\Models\SalamContract;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SalamContractResource extends Resource
{
    protected static ?string $model = SalamContract::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentCurrencyDollar;

    protected static ?string $navigationLabel = 'Akad salam';

    protected static ?string $modelLabel = 'Akad Salam';

    protected static ?string $pluralModelLabel = 'Daftar Akad Salam';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return SalamContractForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SalamContractsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSalamContracts::route('/'),
            'create' => CreateSalamContract::route('/create'),
            'edit' => EditSalamContract::route('/{record}/edit'),
        ];
    }
}
