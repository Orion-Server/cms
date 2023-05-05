<?php

namespace App\Filament\Resources\Orion\ArticleResource\Pages;

use App\Filament\Resources\Orion\ArticleResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArticle extends EditRecord
{
    protected static string $resource = ArticleResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
