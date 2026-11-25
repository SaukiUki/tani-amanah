<?php

declare(strict_types=1);

namespace App\Filament\Resources\SalamContracts\Schemas;

use App\Enums\SalamStatus;
use App\Models\Farmer;
use App\Models\PlantingSeason;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SalamContractForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('planting_season_id')
                    ->label('Musim Tanam')
                    ->relationship('plantingSeason', 'kode_musim')
                    ->default(fn () => PlantingSeason::where('status_aktif', true)->value('id') ?? PlantingSeason::first()?->id)
                    ->required(),

                Select::make('farmer_id')
                    ->label('Petani Anggota')
                    ->relationship('farmer', 'nama')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('modal_di_muka')
                    ->label('Modal di Muka')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                TextInput::make('gabah_dijanjikan_kg')
                    ->label('Gabah Dijanjikan')
                    ->numeric()
                    ->suffix('kg')
                    ->required(),

                TextInput::make('gabah_diserahkan_kg')
                    ->label('Gabah Diserahkan')
                    ->numeric()
                    ->suffix('kg')
                    ->default(0),

                Select::make('status')
                    ->label('Status Akad')
                    ->options([
                        SalamStatus::Pending->value => 'Menunggu panen',
                        SalamStatus::Partial->value => 'Diserahkan sebagian',
                        SalamStatus::Fulfilled->value => 'Sudah diserahkan',
                    ])
                    ->default(SalamStatus::Pending->value)
                    ->required(),
            ]);
    }
}
