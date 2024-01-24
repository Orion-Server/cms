<?php

namespace App\Filament\Resources\Shop\ShopProductResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\LatestResourcesTrait;
use App\Filament\Resources\Shop\ShopProductResource;

class ListShopProducts extends ListRecords
{
    use LatestResourcesTrait;

    protected static string $resource = ShopProductResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
