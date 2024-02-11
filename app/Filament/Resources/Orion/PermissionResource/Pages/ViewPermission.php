<?php

namespace App\Filament\Resources\Orion\PermissionResource\Pages;

use App\Filament\Resources\Orion\PermissionResource;
use Filament\Actions;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPermission extends ViewRecord
{
    protected static string $resource = PermissionResource::class;

    public function getHeaderActions(): array
    {
        return [
            EditAction::make()
        ];
    }
}
