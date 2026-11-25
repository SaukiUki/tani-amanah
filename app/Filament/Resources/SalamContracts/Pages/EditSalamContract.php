<?php

namespace App\Filament\Resources\SalamContracts\Pages;

use App\Filament\Resources\SalamContracts\SalamContractResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSalamContract extends EditRecord
{
    protected static string $resource = SalamContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
