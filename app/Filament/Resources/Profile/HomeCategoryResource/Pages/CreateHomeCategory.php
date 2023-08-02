<?php

namespace App\Filament\Resources\Profile\HomeCategoryResource\Pages;

use App\Filament\Resources\Profile\HomeCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHomeCategory extends CreateRecord
{
    protected static string $resource = HomeCategoryResource::class;
}
