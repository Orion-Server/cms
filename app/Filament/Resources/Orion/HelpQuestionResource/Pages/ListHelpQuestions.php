<?php

namespace App\Filament\Resources\Orion\HelpQuestionResource\Pages;

use App\Filament\Resources\Orion\HelpQuestionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHelpQuestions extends ListRecords
{
    protected static string $resource = HelpQuestionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
