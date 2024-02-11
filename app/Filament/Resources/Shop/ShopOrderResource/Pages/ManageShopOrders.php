<?php

namespace App\Filament\Resources\Shop\ShopOrderResource\Pages;

use App\Filament\Resources\Shop\ShopOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageShopOrders extends ManageRecords
{
    protected static string $resource = ShopOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
