<?php

namespace App\Filament\Resources\User\BanResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\User\BanResource;
use App\Filament\Traits\LatestResourcesTrait;

class ManageBans extends ManageRecords
{
    use LatestResourcesTrait;

    protected static string $resource = BanResource::class;

    protected function getActions(): array
    {
        return [
            // ...
        ];
    }
}
