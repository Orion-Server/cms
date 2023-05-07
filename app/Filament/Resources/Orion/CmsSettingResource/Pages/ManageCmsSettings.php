<?php

namespace App\Filament\Resources\Orion\CmsSettingResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\Orion\CmsSettingResource;
use App\Filament\Traits\LatestResourcesTrait;

class ManageCmsSettings extends ManageRecords
{
    use LatestResourcesTrait;

    protected static string $resource = CmsSettingResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [25, 50, 100];
    }
}
