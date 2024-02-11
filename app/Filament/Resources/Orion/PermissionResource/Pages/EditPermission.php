<?php

namespace App\Filament\Resources\Orion\PermissionResource\Pages;

use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Orion\PermissionResource;

class EditPermission extends EditRecord
{
    protected static string $resource = PermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
