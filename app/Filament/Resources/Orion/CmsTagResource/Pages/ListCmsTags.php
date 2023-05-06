<?php

namespace App\Filament\Resources\Orion\CmsTagResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\LatestResourcesTrait;
use App\Filament\Resources\Orion\CmsTagResource;

class ListCmsTags extends ListRecords
{
    use LatestResourcesTrait;

    protected static string $resource = CmsTagResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
