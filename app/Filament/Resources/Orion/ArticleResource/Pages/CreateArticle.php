<?php

namespace App\Filament\Resources\Orion\ArticleResource\Pages;

use App\Filament\Resources\Orion\ArticleResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;
}
