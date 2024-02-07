<?php

namespace App\Filament\Resources\Shop\ShopProductResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Shop\ShopProductResource;

class ListShopProducts extends ListRecords
{
    protected static string $resource = ShopProductResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
