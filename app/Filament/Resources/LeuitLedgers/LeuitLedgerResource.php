<?php

declare(strict_types=1);

namespace App\Filament\Resources\LeuitLedgers;

use App\Filament\Resources\LeuitLedgers\Pages\ListLeuitLedgers;
use App\Models\LeuitLedger;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LeuitLedgerResource extends Resource
{
    protected static ?string $model = LeuitLedger::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingStorefront;

    protected static ?string $navigationLabel = 'Leuit desa';

    protected static ?string $modelLabel = 'Leuit Desa';

    protected static ?string $pluralModelLabel = 'Cadangan Leuit Desa';

    protected static ?int $navigationSort = 5;

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                LeuitLedger::query()->with('farmer')->where('leuit_kg', '>', 0)
            )
            ->columns([
                TextColumn::make('farmer.nama')
                    ->label('Petani Kontributor')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('leuit_kg')
                    ->label('Stok Disimpan (kg)')
                    ->formatStateUsing(fn ($state): string => number_format((float) $state, 0, ',', '.') . ' kg')
                    ->sortable(),
                TextColumn::make('berat_gabah_kg')
                    ->label('Total Hasil Panen')
                    ->formatStateUsing(fn ($state): string => number_format((float) $state, 0, ',', '.') . ' kg')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Tanggal Masuk')
                    ->dateTime('d M Y')
                    ->sortable(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLeuitLedgers::route('/'),
        ];
    }
}
