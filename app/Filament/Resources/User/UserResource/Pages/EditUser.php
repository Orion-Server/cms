<?php

namespace App\Filament\Resources\User\UserResource\Pages;

use App\Enums\CurrencyType;
use Filament\Pages\Actions;
use App\Services\RconService;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\User\UserResource;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $user = $this->getRecord();

        $data['currency_0'] = $user->currency(CurrencyType::Duckets);
        $data['currency_5'] = $user->currency(CurrencyType::Diamonds);
        $data['currency_101'] = $user->currency(CurrencyType::Points);
        $data['allow_change_username'] = $user->settings->can_change_name;

        return $data;
    }

    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::query()->with(['currencies', 'settings']);
    }

    protected function beforeSave(): void
    {
        $user = $this->getRecord();
        $data = $this->form->getState();
        $rcon = app(RconService::class);

        if ($data['credits'] != $user->credits) {
            $rcon->giveCurrency($user, 'credits', -$user->credits + $data['credits']);
        }

        if ($data['allow_change_username'] != $user->settings->can_change_name) {
            $rcon->sendSafelyFromDashboard('changeUsername',
                [$user, $data['allow_change_username']],
                'RCON: Failed to set can_change_username.'
            );
        }

        $user->currencies->each(function ($currency) use ($data, $user, $rcon) {
            $updatedCurrencyAmount = collect($data)
                ->get("currency_{$currency->type}", 0);

            if ($updatedCurrencyAmount == $currency->amount) return;

            $rcon->sendSafelyFromDashboard('giveCurrency',
                [$user, $currency->type, -$currency->amount + $updatedCurrencyAmount],
                "RCON: Failed to send a currency.",
            );
        });
    }
}
