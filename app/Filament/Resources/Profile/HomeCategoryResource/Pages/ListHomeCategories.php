<?php

namespace App\Filament\Resources\Profile\HomeCategoryResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Profile\HomeCategoryResource;

class ListHomeCategories extends ListRecords
{
    protected static string $resource = HomeCategoryResource::class;

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
