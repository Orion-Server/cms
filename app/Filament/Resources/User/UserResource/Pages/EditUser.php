<?php

namespace App\Filament\Resources\User\UserResource\Pages;

use App\Enums\CurrencyType;
use Filament\Pages\Actions;
use App\Services\RconService;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\User\UserResource;
use App\Models\UserCurrency;
use Illuminate\Database\Eloquent\Model;

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
        return static::$resource::fillWithOutsideData(
            $this->getRecord(),
            $data
        );
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
            $rcon->sendSafelyFromDashboard('giveCurrency',
                [$user, 'credits', -$user->credits + $data['credits']],
                'RCON: Failed to send credits'
            );
        }

        $this->checkUsernameChangedPermission($user, $data, $rcon);
        $this->treatChangedCurrencies($user, $data, $rcon);
        $this->treatChangedUserRank($user, $data, $rcon);
        $this->treatChangedUserMotto($user, $data, $rcon);
    }

    private function checkUsernameChangedPermission(Model $user, array $data, RconService $rcon): void
    {
        if ($data['allow_change_username'] == $user->settings->can_change_name) return;

        $rcon->sendSafelyFromDashboard('changeUsername',
            [$user, $data['allow_change_username']],
            'RCON: Failed to set can_change_username'
        );
    }

    private function treatChangedCurrencies(Model $user, array $data, RconService $rcon): void
    {
        $user->currencies->each(function (UserCurrency $currency) use ($data, $user, $rcon) {
            $updatedCurrencyAmount = collect($data)
                ->get("currency_{$currency->type}", 0);

            if ($updatedCurrencyAmount == $currency->amount) return;

            $rcon->sendSafelyFromDashboard('giveCurrency',
                [$user, $currency->type, -$currency->amount + $updatedCurrencyAmount],
                "RCON: Failed to send a currency",
            );
        });
    }

    private function treatChangedUserRank(Model $user, array $data, RconService $rcon): void
    {
        if($data['rank'] == $user->rank) return;

        if($user->online) {
            $rcon->sendSafelyFromDashboard('alertUser',
                [$user, 'Your rank has been changed. Please, re-enter.'],
                "RCON: Failed to send a user alert",
            );

            sleep(2);
        }

        $rcon->sendSafelyFromDashboard('disconnectUser', [$user], "RCON: Failed to disconnect a user");
        $rcon->sendSafelyFromDashboard('setRank', [$user, $data['rank']], "RCON: Failed to update the user rank");
    }

    private function treatChangedUserMotto(Model $user, array $data, RconService $rcon): void
    {
        if($data['motto'] == $user->motto) return;

        $rcon->sendSafelyFromDashboard('setMotto', [$user, $data['motto']], "RCON: Failed to update the user motto");
    }
}
