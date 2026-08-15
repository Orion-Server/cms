<?php

namespace App\Filament\Resources\Hotel\WordFilterResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Hotel\WordFilterResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageWordFilters extends ManageRecords
{
    protected static string $resource = WordFilterResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
