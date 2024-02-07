<?php

namespace App\Filament\Resources\Profile\HomeCategoryResource\Pages;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Profile\HomeCategoryResource;

class EditHomeCategory extends EditRecord
{
    protected static string $resource = HomeCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->action(function (HomeCategoryResource $resource, Model $record) {
                    if($record->homeItems()->exists()) {
                        Notification::make()
                            ->danger()
                            ->title(__('Unable to delete category'))
                            ->body(__('This category is currently in use by one or more items.'))
                            ->persistent()
                            ->send();

                        $this->halt();
                    }

                    $record->delete();

                    $this->redirect($resource::getUrl('index'));

                    Notification::make()
                        ->success()
                        ->title(__('filament-support::actions/delete.single.messages.deleted'))
                        ->send();
                }),
        ];
    }
}
