<?php

declare(strict_types=1);

namespace App\Filament\Resources\HarvestRecords;

use App\Filament\Resources\HarvestRecords\Pages\CreateHarvestRecord;
use App\Filament\Resources\HarvestRecords\Pages\EditHarvestRecord;
use App\Filament\Resources\HarvestRecords\Pages\ListHarvestRecords;
use App\Filament\Resources\HarvestRecords\Schemas\HarvestRecordForm;
use App\Filament\Resources\HarvestRecords\Tables\HarvestRecordsTable;
use App\Models\HarvestRecord;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HarvestRecordResource extends Resource
{
    protected static ?string $model = HarvestRecord::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedScale;

    protected static ?string $navigationLabel = 'Pembelian gabah';

    protected static ?string $modelLabel = 'Catatan Panen';

    protected static ?string $pluralModelLabel = 'Catatan Panen & Distribusi';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return HarvestRecordForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HarvestRecordsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHarvestRecords::route('/'),
            'create' => CreateHarvestRecord::route('/create'),
            'edit' => EditHarvestRecord::route('/{record}/edit'),
        ];
    }
}
