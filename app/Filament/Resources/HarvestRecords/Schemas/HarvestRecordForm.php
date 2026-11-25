<?php

declare(strict_types=1);

namespace App\Filament\Resources\HarvestRecords\Schemas;

use App\Models\Farmer;
use App\Models\PlantingSeason;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class HarvestRecordForm
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
                    ->label('Petani')
                    ->relationship('farmer', 'nama')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('berat_gabah_kg')
                    ->label('Berat Total Gabah')
                    ->numeric()
                    ->suffix('kg')
                    ->required(),

                TextInput::make('harga_per_kg')
                    ->label('Harga Pembelian')
                    ->numeric()
                    ->prefix('Rp')
                    ->default(7000)
                    ->required(),

                TextInput::make('zakat_kg')
                    ->label('Zakat Pertanian')
                    ->numeric()
                    ->suffix('kg')
                    ->default(0),

                TextInput::make('zakat_disalurkan')
                    ->label('Lembaga Penyalur Zakat')
                    ->default('UPZ Masjid Jami Panosogan')
                    ->maxLength(255),

                TextInput::make('leuit_kg')
                    ->label('Cadangan Leuit Desa')
                    ->numeric()
                    ->suffix('kg')
                    ->default(25),

                TextInput::make('pendapatan_bersih')
                    ->label('Pendapatan Bersih Petani')
                    ->numeric()
                    ->prefix('Rp'),
            ]);
    }
}
