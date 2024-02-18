<?php

namespace App\Filament\Resources\Orion\ArticleResource\Pages;

use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\Orion\ArticleResource;

class ViewArticle extends ViewRecord
{
    protected static string $resource = ArticleResource::class;

    public function getHeaderActions(): array
    {
        return [
            EditAction::make()
        ];
    }
}
