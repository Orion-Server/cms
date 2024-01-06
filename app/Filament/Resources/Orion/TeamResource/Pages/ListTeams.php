<?php

namespace App\Filament\Resources\Orion\TeamResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\LatestResourcesTrait;
use App\Filament\Resources\Orion\TeamResource;

class ListTeams extends ListRecords
{
    use LatestResourcesTrait;

    protected static string $resource = TeamResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
