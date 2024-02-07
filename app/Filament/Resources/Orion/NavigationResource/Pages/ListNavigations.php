<?php

namespace App\Filament\Resources\Orion\NavigationResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Orion\NavigationResource;

class ListNavigations extends ListRecords
{
    protected static string $resource = NavigationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
