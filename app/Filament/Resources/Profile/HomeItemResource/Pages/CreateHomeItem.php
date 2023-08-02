<?php

namespace App\Filament\Resources\Profile\HomeItemResource\Pages;

use App\Filament\Resources\Profile\HomeItemResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHomeItem extends CreateRecord
{
    protected static string $resource = HomeItemResource::class;
}
