<?php

namespace App\Filament\Resources\Profile\HomeItemResource\Pages;

use App\Filament\Resources\Profile\HomeItemResource;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditHomeItem extends EditRecord
{
    protected static string $resource = HomeItemResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->action(function (HomeItemResource $resource, Model $record) {
                    if($record->userHomeItems()->exists()) {
                        Notification::make()
                            ->danger()
                            ->title(__('Unable to delete item'))
                            ->body(__('This item is currently in use by one or more users.'))
                            ->persistent()
                            ->send();

                        $this->halt();
                    }

                    $record->delete();

                    $this->redirect(HomeItemResource::getUrl('index'));

                    Notification::make()
                        ->success()
                        ->title(__('filament-support::actions/delete.single.messages.deleted'))
                        ->send();
                }),
        ];
    }
}
