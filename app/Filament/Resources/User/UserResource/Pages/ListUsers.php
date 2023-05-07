<?php

namespace App\Filament\Resources\User\UserResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\User\UserResource;
use App\Filament\Traits\LatestResourcesTrait;

class ListUsers extends ListRecords
{
    use LatestResourcesTrait;

    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
