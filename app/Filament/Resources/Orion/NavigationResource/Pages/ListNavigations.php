<?php

namespace App\Filament\Resources\Orion\NavigationResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Orion\NavigationResource;

class ListNavigations extends ListRecords
{
    protected static string $resource = NavigationResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
