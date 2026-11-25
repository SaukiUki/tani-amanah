<?php

declare(strict_types=1);

namespace App\Filament\Resources\ZakatRecords;

use App\Filament\Resources\ZakatRecords\Pages\ListZakatRecords;
use App\Models\ZakatRecord;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ZakatRecordResource extends Resource
{
    protected static ?string $model = ZakatRecord::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHeart;

    protected static ?string $navigationLabel = 'Zakat panen';

    protected static ?string $modelLabel = 'Zakat Panen';

    protected static ?string $pluralModelLabel = 'Catatan Zakat Panen';

    protected static ?int $navigationSort = 7;

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                ZakatRecord::query()->with('farmer')->where('zakat_kg', '>', 0)
            )
            ->columns([
                TextColumn::make('farmer.nama')
                    ->label('Muzakki (Petani)')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('zakat_kg')
                    ->label('Zakat (kg)')
                    ->formatStateUsing(fn ($state): string => number_format((float) $state, 1, ',', '.') . ' kg')
                    ->sortable(),
                TextColumn::make('zakat_disalurkan')
                    ->label('Lembaga Penyalur')
                    ->searchable()
                    ->badge()
                    ->color('success'),
                TextColumn::make('created_at')
                    ->label('Tanggal Catat')
                    ->dateTime('d M Y')
                    ->sortable(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListZakatRecords::route('/'),
        ];
    }
}
