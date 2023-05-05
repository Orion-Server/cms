<?php

namespace App\Filament\Resources\Hotel\AchievementResource\Pages;

use App\Filament\Resources\Hotel\AchievementResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAchievements extends ListRecords
{
    protected static string $resource = AchievementResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
