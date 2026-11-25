<?php

namespace App\Filament\Resources\HarvestRecords\Pages;

use App\Filament\Resources\HarvestRecords\HarvestRecordResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHarvestRecord extends EditRecord
{
    protected static string $resource = HarvestRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
