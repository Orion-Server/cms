<?php

namespace App\Filament\Resources\Orion\ArticleResource\Pages;

use App\Filament\Resources\Orion\ArticleResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArticles extends ListRecords
{
    protected static string $resource = ArticleResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
