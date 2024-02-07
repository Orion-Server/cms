<?php

namespace App\Filament\Resources\Orion\NavigationResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Orion\NavigationResource;

class EditNavigation extends EditRecord
{
    protected static string $resource = NavigationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
