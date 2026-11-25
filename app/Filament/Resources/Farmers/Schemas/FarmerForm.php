<?php

declare(strict_types=1);

namespace App\Filament\Resources\Farmers\Schemas;

use App\Enums\IrrigationType;
use App\Models\Village;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FarmerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('village_id')
                    ->label('Desa')
                    ->relationship('village', 'nama_desa')
                    ->default(fn () => Village::first()?->id)
                    ->required(),

                TextInput::make('nama')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),

                TextInput::make('nomor_wa')
                    ->label('Nomor WhatsApp')
                    ->tel()
                    ->placeholder('081234567890')
                    ->maxLength(20),

                TextInput::make('luas_lahan_ha')
                    ->label('Luas Lahan')
                    ->numeric()
                    ->suffix('ha')
                    ->required(),

                Select::make('blok_lahan')
                    ->label('Blok Lahan')
                    ->options([
                        'Blok Cibeber' => 'Blok Cibeber',
                        'Blok Leuwi Kiara' => 'Blok Leuwi Kiara',
                        'Blok Pasir Gadung' => 'Blok Pasir Gadung',
                        'Blok Pematang Tengah' => 'Blok Pematang Tengah',
                        'Blok Ranca Ilat' => 'Blok Ranca Ilat',
                        'Blok Babakan' => 'Blok Babakan',
                    ])
                    ->searchable()
                    ->required(),

                Select::make('tipe_irigasi')
                    ->label('Tipe Irigasi')
                    ->options([
                        IrrigationType::Paid->value => 'Irigasi Pompa (Berbayar)',
                        IrrigationType::Rainfed->value => 'Tadah Hujan',
                    ])
                    ->default(IrrigationType::Paid->value)
                    ->required(),

                TextInput::make('foto_url')
                    ->label('URL Foto Petani')
                    ->url()
                    ->placeholder('https://images.unsplash.com/...'),
            ]);
    }
}
