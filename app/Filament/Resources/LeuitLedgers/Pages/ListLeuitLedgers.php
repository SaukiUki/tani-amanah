<?php

declare(strict_types=1);

namespace App\Filament\Resources\LeuitLedgers\Pages;

use App\Filament\Resources\LeuitLedgers\LeuitLedgerResource;
use Filament\Resources\Pages\ListRecords;

class ListLeuitLedgers extends ListRecords
{
    protected static string $resource = LeuitLedgerResource::class;
}
