<?php

namespace App\Filament\Resources\Shop\ShopCategoryResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\LatestResourcesTrait;
use App\Filament\Resources\Shop\ShopCategoryResource;

class ListShopCategories extends ListRecords
{
    use LatestResourcesTrait;

    protected static string $resource = ShopCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
