<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\HarvestRecord;
use App\Models\SalamContract;
use App\Models\Subscription;
use App\Models\Village;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget as BaseStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseStatsOverviewWidget
{
    protected static ?bool $isLazyLoaded = false;

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // 1. Anggota dan lahan: 27,05 ha sawah (48 petani aktif)
        $villageArea = Village::query()->value('total_luas_ha');
        $areaValue = $villageArea ? number_format((float) $villageArea, 2, ',', '.') . ' ha sawah' : '27,05 ha sawah';
        $farmerCount = 48; // 48 petani aktif pada MT-1 2027

        // 2. Dana salam diterima: dihitung dinamis dari tabel subscriptions berstatus paid
        $paidSubs = Subscription::query()->where('payment_status', 'paid');
        $subCount = $paidSubs->count() ?: 150;
        $salamFromSubs = (float) $paidSubs->sum('salam_allocation_amount');
        $salamSum = $salamFromSubs > 0 ? $salamFromSubs : (float) SalamContract::query()->sum('modal_di_muka');
        $salamJt = $salamSum > 0 ? number_format($salamSum / 1_000_000, 1, ',', '.') : '62,1';

        // 3. Pembelian gabah: 7,3 ton (Rp 7.000/kg, di atas HPP Rp 6.500)
        $salamGabahKg = (float) SalamContract::query()->sum('gabah_dijanjikan_kg');
        $gabahTon = $salamGabahKg > 0 ? number_format($salamGabahKg / 1_000, 1, ',', '.') : '7,3';

        // 4. Stok leuit desa: 1,2 ton (Cadangan pangan dan petani darurat)
        $leuitSumKg = (float) HarvestRecord::query()->sum('leuit_kg');
        $leuitTon = $leuitSumKg > 0 ? number_format($leuitSumKg / 1_000, 1, ',', '.') : '1,2';

        return [
            Stat::make('Anggota dan lahan', $areaValue)
                ->icon(Heroicon::OutlinedUserGroup)
                ->description("{$farmerCount} petani aktif")
                ->descriptionIcon(Heroicon::UserGroup, position: IconPosition::Before)
                ->color('primary')
                ->chart([22, 24, 25, 26, 27.05]),

            Stat::make('Dana salam diterima', "Rp {$salamJt} jt")
                ->icon(Heroicon::OutlinedBanknotes)
                ->description("{$subCount} pelanggan × 3 bulan")
                ->descriptionIcon(Heroicon::Banknotes, position: IconPosition::Before)
                ->color('primary')
                ->chart([20, 35, 48, 56, 62.1]),

            Stat::make('Pembelian gabah', "{$gabahTon} ton")
                ->icon(Heroicon::OutlinedScale)
                ->description('Rp 7.000/kg, di atas HPP Rp 6.500')
                ->descriptionIcon(Heroicon::Scale, position: IconPosition::Before)
                ->color('warning')
                ->chart([2, 4, 5.5, 6.8, 7.3]),

            Stat::make('Stok leuit desa', "{$leuitTon} ton")
                ->icon(Heroicon::OutlinedBuildingStorefront)
                ->description('Cadangan pangan dan petani darurat')
                ->descriptionIcon(Heroicon::BuildingStorefront, position: IconPosition::Before)
                ->color('primary')
                ->chart([0.2, 0.5, 0.8, 1.0, 1.2]),
        ];
    }
}
