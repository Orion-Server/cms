<?php

namespace App\Filament\Resources\Shop\ShopCategoryResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Shop\ShopCategoryResource;

class ListShopCategories extends ListRecords
{
    protected static string $resource = ShopCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
