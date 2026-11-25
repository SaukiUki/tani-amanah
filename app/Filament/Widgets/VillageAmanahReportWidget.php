<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\AmanahReport;
use App\Models\HarvestRecord;
use Filament\Widgets\Widget;

class VillageAmanahReportWidget extends Widget
{
    protected static ?bool $isLazyLoaded = false;

    protected string $view = 'filament.widgets.village-amanah-report-widget';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $totalFarmers = 48;

        $jeramiCount = 38;
        $jeramiPercent = (int) round(($jeramiCount / $totalFarmers) * 100);

        $pupukCount = 35;
        $pupukPercent = (int) round(($pupukCount / $totalFarmers) * 100);

        $bebasIjonCount = 41;
        $bebasIjonPercent = (int) round(($bebasIjonCount / $totalFarmers) * 100);

        $zakatSummary = '2,9 ton • 31 petani';
        $pohonSummary = '126 pohon';

        return [
            'quote' => '“Lojor teu meunang dipotong, pondok teu meunang disambung.”',
            'quoteMeaning' => 'Filosofi kejujuran leluhur Banten: tidak mengurangi timbangan, tidak melebihkan janji, dan menjaga tanah titipan dengan penuh amanah.',
            'totalFarmers' => $totalFarmers,
            'jeramiCount' => $jeramiCount,
            'jeramiPercent' => $jeramiPercent,
            'pupukCount' => $pupukCount,
            'pupukPercent' => $pupukPercent,
            'bebasIjonCount' => $bebasIjonCount,
            'bebasIjonPercent' => $bebasIjonPercent,
            'zakatSummary' => $zakatSummary,
            'pohonSummary' => $pohonSummary,
        ];
    }
}
