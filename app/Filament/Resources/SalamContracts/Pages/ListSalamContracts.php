<?php

namespace App\Filament\Resources\SalamContracts\Pages;

use App\Filament\Resources\SalamContracts\SalamContractResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSalamContracts extends ListRecords
{
    protected static string $resource = SalamContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
