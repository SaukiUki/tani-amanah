<?php

declare(strict_types=1);

namespace App\Filament\Resources\AmanahReports;

use App\Filament\Resources\AmanahReports\Pages\ListAmanahReports;
use App\Models\AmanahReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AmanahReportResource extends Resource
{
    protected static ?string $model = AmanahReport::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static ?string $navigationLabel = 'Rapor amanah';

    protected static ?string $modelLabel = 'Rapor Amanah';

    protected static ?string $pluralModelLabel = 'Rapor Integritas & Ekologi';

    protected static ?int $navigationSort = 8;

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                AmanahReport::query()->with('farmer')
            )
            ->columns([
                TextColumn::make('farmer.nama')
                    ->label('Petani')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                IconColumn::make('jerami_tidak_dibakar')
                    ->label('Jerami Terjaga')
                    ->boolean(),
                IconColumn::make('pupuk_sesuai_dosis')
                    ->label('Pupuk Berimbang')
                    ->boolean(),
                IconColumn::make('bebas_ijon')
                    ->label('Bebas Ijon')
                    ->boolean(),
                TextColumn::make('pohon_ditanam')
                    ->label('Pohon Ditanam')
                    ->suffix(' pohon')
                    ->sortable(),
                TextColumn::make('qr_slug')
                    ->label('Kode QR')
                    ->fontFamily('mono')
                    ->color('gray'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAmanahReports::route('/'),
        ];
    }
}
