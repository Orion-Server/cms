<?php

namespace App\Filament\Resources\Orion\TeamResource\Pages;

use App\Filament\Resources\Orion\TeamResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTeam extends EditRecord
{
    protected static string $resource = TeamResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
