<?php

namespace App\Filament\Resources\Orion\HelpQuestionResource\Pages;

use App\Filament\Resources\Orion\HelpQuestionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

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
