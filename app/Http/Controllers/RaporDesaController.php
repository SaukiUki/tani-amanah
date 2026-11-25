<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\AmanahReport;
use App\Models\Farmer;
use App\Models\HarvestRecord;
use App\Models\PlantingSeason;
use App\Models\SalamContract;
use App\Models\Subscription;
use App\Models\Village;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;

class RaporDesaController extends Controller
{
    public function preview(): View
    {
        $village = Village::first() ?? new Village([
            'nama_desa' => 'Desa Panosogan',
            'kecamatan' => 'Kec. Cikeusal',
            'kabupaten' => 'Kab. Serang',
            'total_luas_ha' => 27.05,
        ]);

        $season = PlantingSeason::where('status_aktif', true)->first() ?? PlantingSeason::first();
        $seasonCode = $season?->kode_musim ?? 'MT-1 2027';
        $syukuranDate = $season?->tanggal_syukuran_panen
            ? Carbon::parse($season->tanggal_syukuran_panen)->translatedFormat('l, d F Y')
            : 'Sabtu, 17 Juli 2027';

        $farmers = Farmer::query()
            ->with([
                'salamContracts' => fn ($q) => $season ? $q->where('planting_season_id', $season->id) : $q,
                'harvestRecords' => fn ($q) => $season ? $q->where('planting_season_id', $season->id) : $q,
                'amanahReports' => fn ($q) => $season ? $q->where('planting_season_id', $season->id) : $q,
            ])
            ->orderBy('id')
            ->get();

        $activeFarmersCount = $farmers->count() ?: 48;
        $totalLuas = (float) ($village->total_luas_ha ?? 27.05);

        $totalSalamDana = (float) SalamContract::sum('modal_di_muka') ?: 62100000;
        $totalSubscriptions = Subscription::count() ?: 150;

        $totalGabahBeliKg = (float) HarvestRecord::sum('berat_gabah_kg') ?: 7300;
        $avgHarga = (float) HarvestRecord::avg('harga_per_kg') ?: 7000;

        $totalLeuitKg = (float) HarvestRecord::sum('leuit_kg') ?: 1200;

        $jeramiCount = AmanahReport::where('jerami_tidak_dibakar', true)->count() ?: 38;
        $pupukCount = AmanahReport::where('pupuk_sesuai_dosis', true)->count() ?: 35;
        $bebasIjonCount = AmanahReport::where('bebas_ijon', true)->count() ?: 41;
        $zakatSumKg = (float) HarvestRecord::sum('zakat_kg') ?: 2900;
        $zakatFarmersCount = HarvestRecord::where('zakat_kg', '>', 0)->count() ?: 31;
        $pohonCount = (int) AmanahReport::sum('pohon_ditanam') ?: 126;

        return view('pdf.rapor-desa', [
            'village' => $village,
            'season' => $season,
            'seasonCode' => $seasonCode,
            'syukuranDate' => $syukuranDate,
            'farmers' => $farmers,
            'activeFarmersCount' => $activeFarmersCount,
            'totalLuas' => $totalLuas,
            'totalSalamDana' => $totalSalamDana,
            'totalSubscriptions' => $totalSubscriptions,
            'totalGabahBeliKg' => $totalGabahBeliKg,
            'avgHarga' => $avgHarga,
            'totalLeuitKg' => $totalLeuitKg,
            'jeramiCount' => $jeramiCount,
            'pupukCount' => $pupukCount,
            'bebasIjonCount' => $bebasIjonCount,
            'zakatSumKg' => $zakatSumKg,
            'zakatFarmersCount' => $zakatFarmersCount,
            'pohonCount' => $pohonCount,
        ]);
    }
}
