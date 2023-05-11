<?php

namespace App\Filament\Resources\Orion\ReactionResource\Pages;

use App\Filament\Resources\Orion\ReactionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageReactions extends ManageRecords
{
    protected static string $resource = ReactionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
