<?php

namespace App\Filament\Resources\Shop\ShopProductResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Shop\ShopProductResource;

class EditShopProduct extends EditRecord
{
    protected static string $resource = ShopProductResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
