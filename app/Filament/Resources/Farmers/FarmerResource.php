<?php

declare(strict_types=1);

namespace App\Filament\Resources\Farmers;

use App\Filament\Resources\Farmers\Pages\CreateFarmer;
use App\Filament\Resources\Farmers\Pages\EditFarmer;
use App\Filament\Resources\Farmers\Pages\ListFarmers;
use App\Filament\Resources\Farmers\Schemas\FarmerForm;
use App\Filament\Resources\Farmers\Tables\FarmersTable;
use App\Models\Farmer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FarmerResource extends Resource
{
    protected static ?string $model = Farmer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $navigationLabel = 'Anggota dan lahan';

    protected static ?string $modelLabel = 'Petani';

    protected static ?string $pluralModelLabel = 'Petani Binaan';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return FarmerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FarmersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFarmers::route('/'),
            'create' => CreateFarmer::route('/create'),
            'edit' => EditFarmer::route('/{record}/edit'),
        ];
    }
}
