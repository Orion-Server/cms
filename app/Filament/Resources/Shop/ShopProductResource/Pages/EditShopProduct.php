<?php

namespace App\Filament\Resources\Shop\ShopProductResource\Pages;

use App\Filament\Resources\Shop\ShopProductResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

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
