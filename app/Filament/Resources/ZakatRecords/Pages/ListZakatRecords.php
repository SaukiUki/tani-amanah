<?php

declare(strict_types=1);

namespace App\Filament\Resources\ZakatRecords\Pages;

use App\Filament\Resources\ZakatRecords\ZakatRecordResource;
use Filament\Resources\Pages\ListRecords;

class ListZakatRecords extends ListRecords
{
    protected static string $resource = ZakatRecordResource::class;
}
