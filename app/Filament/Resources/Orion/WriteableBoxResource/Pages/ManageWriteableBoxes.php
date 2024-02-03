<?php

namespace App\Filament\Resources\Orion\WriteableBoxResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Traits\LatestResourcesTrait;
use App\Filament\Resources\Orion\WriteableBoxResource;

class ManageWriteableBoxes extends ManageRecords
{
    use LatestResourcesTrait;

    protected static string $resource = WriteableBoxResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
