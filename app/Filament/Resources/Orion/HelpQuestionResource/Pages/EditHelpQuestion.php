<?php

namespace App\Filament\Resources\Orion\HelpQuestionResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Orion\HelpQuestionResource;

class EditHelpQuestion extends EditRecord
{
    protected static string $resource = HelpQuestionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
