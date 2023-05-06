<?php

namespace App\Filament\Resources\Orion\CmsTagResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Orion\CmsTagResource;

class EditCmsTag extends EditRecord
{
    protected static string $resource = CmsTagResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
