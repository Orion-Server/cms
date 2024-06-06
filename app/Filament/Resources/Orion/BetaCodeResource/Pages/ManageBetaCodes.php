<?php

namespace App\Filament\Resources\Orion\BetaCodeResource\Pages;

use App\Filament\Resources\Orion\BetaCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBetaCodes extends ManageRecords
{
    protected static string $resource = BetaCodeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
