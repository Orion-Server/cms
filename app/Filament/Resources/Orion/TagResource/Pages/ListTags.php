<?php

namespace App\Filament\Resources\Orion\TagResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\LatestResourcesTrait;
use App\Filament\Resources\Orion\TagResource;

class ListTags extends ListRecords
{
    use LatestResourcesTrait;

    protected static string $resource = TagResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
