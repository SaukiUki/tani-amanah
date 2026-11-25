<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Enums\SalamStatus;
use App\Models\SalamContract;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class SalamContractsTableWidget extends TableWidget
{
    protected static ?bool $isLazyLoaded = false;

    protected static ?int $sort = 2;

    protected static ?string $heading = 'Akad salam musim ini';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                SalamContract::query()
                    ->with('farmer')
                    ->orderBy('id', 'asc')
            )
            ->heading('Akad salam musim ini')
            ->defaultPaginationPageOption(10)
            ->columns([
                TextColumn::make('farmer.nama')
                    ->label('Petani')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (SalamContract $record): string => $record->farmer?->blok_lahan ?? '-'),

                TextColumn::make('farmer.luas_lahan_ha')
                    ->label('Luas (ha)')
                    ->formatStateUsing(fn ($state): string => number_format((float) $state, 2, ',', '.') . ' ha')
                    ->sortable(),

                TextColumn::make('modal_di_muka')
                    ->label('Modal di muka (Rp)')
                    ->formatStateUsing(fn ($state): string => 'Rp ' . number_format((float) $state, 0, ',', '.'))
                    ->sortable(),

                TextColumn::make('gabah_dijanjikan_kg')
                    ->label('Gabah dijanjikan (kg)')
                    ->formatStateUsing(fn ($state): string => number_format((float) $state, 0, ',', '.') . ' kg')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(function ($state): string {
                        if ($state instanceof SalamStatus) {
                            return $state->label();
                        }
                        $enum = SalamStatus::tryFrom((string) $state);
                        return $enum?->label() ?? (string) $state;
                    })
                    ->color(function ($state): string {
                        $value = $state instanceof SalamStatus ? $state->value : (string) $state;
                        return match ($value) {
                            'fulfilled', SalamStatus::Fulfilled->value => 'success', // hijau
                            'pending', SalamStatus::Pending->value => 'warning',     // kuning/amber
                            'partial', SalamStatus::Partial->value => 'info',        // biru
                            default => 'gray',
                        };
                    }),
            ]);
    }
}
