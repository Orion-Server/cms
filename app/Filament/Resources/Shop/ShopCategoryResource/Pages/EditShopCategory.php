<?php

namespace App\Filament\Resources\Shop\ShopCategoryResource\Pages;

use App\Filament\Resources\Shop\ShopCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

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
