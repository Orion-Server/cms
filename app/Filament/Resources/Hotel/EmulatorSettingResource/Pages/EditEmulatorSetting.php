<?php

namespace App\Filament\Resources\Hotel\EmulatorSettingResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\Hotel\EmulatorSettingResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmulatorSetting extends EditRecord
{
    protected static string $resource = EmulatorSettingResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
