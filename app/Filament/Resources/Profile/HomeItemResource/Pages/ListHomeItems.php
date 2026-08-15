<?php

namespace App\Filament\Resources\Profile\HomeItemResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Profile\HomeItemResource;

class ListHomeItems extends ListRecords
{
    protected static string $resource = HomeItemResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getTableReorderColumn(): ?string
    {
        return 'order';
    }
}
