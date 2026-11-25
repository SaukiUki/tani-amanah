<?php

declare(strict_types=1);

namespace App\Filament\Resources\SalamContracts\Tables;

use App\Enums\SalamStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SalamContractsTable
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

                TextColumn::make('modal_di_muka')
                    ->label('Modal di Muka')
                    ->formatStateUsing(fn ($state): string => 'Rp ' . number_format((float) $state, 0, ',', '.'))
                    ->sortable(),

                TextColumn::make('gabah_dijanjikan_kg')
                    ->label('Gabah Dijanjikan')
                    ->formatStateUsing(fn ($state): string => number_format((float) $state, 0, ',', '.') . ' kg')
                    ->sortable(),

                TextColumn::make('gabah_diserahkan_kg')
                    ->label('Gabah Diserahkan')
                    ->formatStateUsing(fn ($state): string => number_format((float) $state, 0, ',', '.') . ' kg')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(function ($state): string {
                        if ($state instanceof SalamStatus) {
                            return $state->label();
                        }
                        return SalamStatus::tryFrom((string) $state)?->label() ?? (string) $state;
                    })
                    ->color(function ($state): string {
                        $val = $state instanceof SalamStatus ? $state->value : (string) $state;
                        return match ($val) {
                            'fulfilled', SalamStatus::Fulfilled->value => 'success',
                            'pending', SalamStatus::Pending->value => 'warning',
                            'partial', SalamStatus::Partial->value => 'info',
                            default => 'gray',
                        };
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Akad')
                    ->options([
                        SalamStatus::Pending->value => 'Menunggu panen',
                        SalamStatus::Partial->value => 'Diserahkan sebagian',
                        SalamStatus::Fulfilled->value => 'Sudah diserahkan',
                    ]),
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
