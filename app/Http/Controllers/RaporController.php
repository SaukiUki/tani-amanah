<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\AmanahReport;
use App\Models\HarvestRecord;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;

class RaporController extends Controller
{
    public function show(string $qr_slug): View
    {
        $report = AmanahReport::query()
            ->with(['farmer.village', 'plantingSeason'])
            ->where('qr_slug', $qr_slug)
            ->firstOrFail();

        $harvest = HarvestRecord::query()
            ->where('farmer_id', $report->farmer_id)
            ->where('planting_season_id', $report->planting_season_id)
            ->first();

        // Carbon date formatting in Indonesian
        $syukuranDate = $report->plantingSeason?->tanggal_syukuran_panen
            ? Carbon::parse($report->plantingSeason->tanggal_syukuran_panen)->translatedFormat('l, d F Y')
            : 'Sabtu, 17 Juli 2027';

        return view('rapor.show', [
            'report' => $report,
            'farmer' => $report->farmer,
            'season' => $report->plantingSeason,
            'village' => $report->farmer?->village,
            'harvest' => $harvest,
            'syukuranDate' => $syukuranDate,
        ]);
    }
}
