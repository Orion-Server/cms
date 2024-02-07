<?php

namespace App\Filament\Resources\Orion\WriteableBoxResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\Orion\WriteableBoxResource;

class ManageWriteableBoxes extends ManageRecords
{
    protected static string $resource = WriteableBoxResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
