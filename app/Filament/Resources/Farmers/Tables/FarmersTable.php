<?php

declare(strict_types=1);

namespace App\Filament\Resources\Farmers\Tables;

use App\Enums\IrrigationType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class FarmersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('foto_url')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl('https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&q=80&w=200'),

                TextColumn::make('nama')
                    ->label('Nama Petani')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('nomor_wa')
                    ->label('WhatsApp')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('luas_lahan_ha')
                    ->label('Luas Lahan')
                    ->formatStateUsing(fn ($state): string => number_format((float) $state, 2, ',', '.') . ' ha')
                    ->sortable(),

                TextColumn::make('blok_lahan')
                    ->label('Blok Lahan')
                    ->badge()
                    ->sortable()
                    ->searchable(),

                TextColumn::make('tipe_irigasi')
                    ->label('Tipe Irigasi')
                    ->badge()
                    ->formatStateUsing(function ($state): string {
                        if ($state instanceof IrrigationType) {
                            return $state->label();
                        }
                        return IrrigationType::tryFrom((string) $state)?->label() ?? (string) $state;
                    })
                    ->color(function ($state): string {
                        $val = $state instanceof IrrigationType ? $state->value : (string) $state;
                        return $val === IrrigationType::Paid->value ? 'success' : 'warning';
                    }),

                TextColumn::make('village.nama_desa')
                    ->label('Desa')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('blok_lahan')
                    ->label('Blok Lahan')
                    ->options([
                        'Blok Cibeber' => 'Blok Cibeber',
                        'Blok Leuwi Kiara' => 'Blok Leuwi Kiara',
                        'Blok Pasir Gadung' => 'Blok Pasir Gadung',
                        'Blok Pematang Tengah' => 'Blok Pematang Tengah',
                        'Blok Ranca Ilat' => 'Blok Ranca Ilat',
                        'Blok Babakan' => 'Blok Babakan',
                    ]),
                SelectFilter::make('tipe_irigasi')
                    ->label('Tipe Irigasi')
                    ->options([
                        IrrigationType::Paid->value => 'Irigasi Pompa (Berbayar)',
                        IrrigationType::Rainfed->value => 'Tadah Hujan',
                    ]),
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
