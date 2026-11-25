<?php

declare(strict_types=1);

namespace App\Filament\Resources\HarvestRecords\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class HarvestRecordsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('farmer.nama')
                    ->label('Petani')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record): string => $record->farmer?->blok_lahan ?? '-'),

                TextColumn::make('plantingSeason.kode_musim')
                    ->label('Musim')
                    ->badge()
                    ->sortable(),

                TextColumn::make('berat_gabah_kg')
                    ->label('Hasil Panen')
                    ->formatStateUsing(fn ($state): string => number_format((float) $state, 0, ',', '.') . ' kg')
                    ->sortable(),

                TextColumn::make('harga_per_kg')
                    ->label('Harga/kg')
                    ->formatStateUsing(fn ($state): string => 'Rp ' . number_format((float) $state, 0, ',', '.'))
                    ->sortable(),

                TextColumn::make('zakat_kg')
                    ->label('Zakat')
                    ->formatStateUsing(fn ($state): string => number_format((float) $state, 1, ',', '.') . ' kg')
                    ->description(fn ($record): string => $record->zakat_disalurkan ?? '')
                    ->sortable(),

                TextColumn::make('leuit_kg')
                    ->label('Stok Leuit')
                    ->formatStateUsing(fn ($state): string => number_format((float) $state, 0, ',', '.') . ' kg')
                    ->sortable(),

                TextColumn::make('pendapatan_bersih')
                    ->label('Pendapatan Bersih')
                    ->formatStateUsing(fn ($state): string => 'Rp ' . number_format((float) $state, 0, ',', '.'))
                    ->sortable()
                    ->color('success')
                    ->weight('bold'),
            ])
            ->filters([
                SelectFilter::make('planting_season_id')
                    ->label('Musim Tanam')
                    ->relationship('plantingSeason', 'kode_musim'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
