<?php

namespace App\Filament\Resources\Hotel\CommandLogResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use App\Filament\Traits\LatestResourcesTrait;
use App\Filament\Resources\Hotel\CommandLogResource;

class ManageCommandLogs extends ManageRecords
{
    use LatestResourcesTrait;

    protected static string $resource = CommandLogResource::class;

    protected function getActions(): array
    {
        return [];
    }

    public function getPrimaryKey(): string
    {
        return 'timestamp';
    }
}
