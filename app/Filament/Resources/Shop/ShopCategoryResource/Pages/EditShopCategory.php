<?php

namespace App\Filament\Resources\Shop\ShopCategoryResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Shop\ShopCategoryResource;

class EditShopCategory extends EditRecord
{
    protected static string $resource = ShopCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
