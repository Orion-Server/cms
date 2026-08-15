<?php

namespace App\Filament\Resources\Orion\CmsSettingResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\Orion\CmsSettingResource;

class ManageCmsSettings extends ManageRecords
{
    protected static string $resource = CmsSettingResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [25, 50, 100];
    }
}
