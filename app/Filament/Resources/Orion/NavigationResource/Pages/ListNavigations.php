<?php

namespace App\Filament\Resources\Orion\NavigationResource\Pages;

use App\Filament\Resources\Orion\NavigationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

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
