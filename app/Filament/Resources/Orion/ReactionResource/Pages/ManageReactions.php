<?php

namespace App\Filament\Resources\Orion\ReactionResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Traits\LatestResourcesTrait;
use App\Filament\Resources\Orion\ReactionResource;

class ManageReactions extends ManageRecords
{
    use LatestResourcesTrait;

    protected static string $resource = ReactionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
