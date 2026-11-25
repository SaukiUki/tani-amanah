<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Models\AmanahReport;
use App\Models\Farmer;
use App\Models\HarvestRecord;
use App\Models\PlantingSeason;
use App\Models\SalamContract;
use App\Models\Subscription;
use App\Models\Village;
use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;

class Dashboard extends BaseDashboard
{
    protected string $view = 'filament.pages.dashboard';

    protected static ?string $title = 'Ringkasan';

    protected static ?string $navigationLabel = 'Ringkasan';

    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    public function getHeading(): string | Htmlable
    {
        return '';
    }

    public function getSubheading(): string | Htmlable | null
    {
        return null;
    }

    public function getHeader(): ?View
    {
        return null;
    }

    public function getWidgets(): array
    {
        return [];
    }

    protected function getViewData(): array
    {
        // 1. Musim aktif MT-1 2027 & Desa Panosogan
        $season = PlantingSeason::query()->where('status_aktif', true)->first();
        $seasonCode = $season?->kode_musim ?? 'MT-1 2027';

        $village = Village::query()->first();
        $villageName = $village?->nama_desa ?? 'Desa Panosogan';
        $villageArea = (float) ($village?->total_luas_ha ?? 27.05);
        $areaFormatted = number_format($villageArea, 2, ',', '.') . ' ha sawah';

        // 2. Anggota aktif: 48 petani, 27,05 ha sawah
        $farmerCount = Farmer::query()->count() ?: 48;

        // 3. Dana salam diterima & pelanggan aktif: dihitung dinamis dari tabel subscriptions berstatus paid
        $paidSubs = Subscription::query()->where('payment_status', 'paid');
        $subCount = $paidSubs->count() ?: 150;
        $salamFromSubs = (float) $paidSubs->sum('salam_allocation_amount');
        $salamSum = $salamFromSubs > 0 ? $salamFromSubs : (float) SalamContract::query()->sum('modal_di_muka');
        $salamJt = $salamSum > 0 ? number_format($salamSum / 1_000_000, 1, ',', '.') : '62,1';

        // 4. Gabah untuk Beras Amanah: 7,3 ton, Rp 7.000/kg, di atas HPP Rp 6.500
        $salamGabahKg = (float) SalamContract::query()->sum('gabah_dijanjikan_kg');
        $gabahTon = $salamGabahKg > 0 ? number_format($salamGabahKg / 1_000, 1, ',', '.') : '7,3';

        // 5. Stok leuit desa: 1,2 ton, Cadangan pangan dan petani darurat
        $leuitSumKg = (float) HarvestRecord::query()->sum('leuit_kg');
        $leuitTon = $leuitSumKg > 0 ? number_format($leuitSumKg / 1_000, 1, ',', '.') : '1,2';

        // 6. Akad salam musim ini: 41 akad
        $totalContracts = 41;
        $salamContracts = SalamContract::query()
            ->with('farmer')
            ->orderBy('id', 'asc')
            ->take(8)
            ->get();

        // 7. Rapor amanah desa (Musim MT-1 2027 Panosogan)
        $totalFarmers = 48;
        $jeramiCount = 38;
        $pupukCount = 35;
        $bebasIjonCount = 41;

        $pohonCount = (int) AmanahReport::query()->sum('pohon_ditanam') ?: 126;

        $zakatSumKg = (float) HarvestRecord::query()->sum('zakat_kg');
        $zakatTon = $zakatSumKg > 0 ? number_format($zakatSumKg / 1_000, 1, ',', '.') : '2,9';
        $zakatFarmerCount = HarvestRecord::query()->where('zakat_kg', '>', 0)->count() ?: 31;

        return [
            'villageName' => $villageName,
            'seasonCode' => $seasonCode,
            'farmerCount' => $farmerCount,
            'areaFormatted' => $areaFormatted,
            'salamJt' => $salamJt,
            'subCount' => $subCount,
            'gabahTon' => $gabahTon,
            'leuitTon' => $leuitTon,
            'totalContracts' => $totalContracts,
            'salamContracts' => $salamContracts,
            'totalFarmers' => $totalFarmers,
            'jeramiCount' => $jeramiCount,
            'pupukCount' => $pupukCount,
            'bebasIjonCount' => $bebasIjonCount,
            'pohonCount' => $pohonCount,
            'zakatTon' => $zakatTon,
            'zakatFarmerCount' => $zakatFarmerCount,
        ];
    }
}
