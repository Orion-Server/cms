<?php

namespace App\Filament\Resources\User\UserResource\Pages;

use App\Enums\CurrencyType;
use App\Filament\Resources\User\UserResource;
use App\Services\RconService;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

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
        $data['currency_0'] = $this->getRecord()->currency(CurrencyType::Duckets);
        $data['currency_5'] = $this->getRecord()->currency(CurrencyType::Diamonds);
        $data['currency_101'] = $this->getRecord()->currency(CurrencyType::Points);

        return $data;
    }

    protected function beforeSave(): void
    {
        $user = $this->getRecord()->fresh(['currencies']);
        $data = $this->form->getState();
        $rcon = app(RconService::class);

        if($data['credits'] != $user->credits) {
            $rcon->giveCurrency($user, 'credits', -$user->credits + $data['credits']);
        }

        $user
            ->currencies
            ->each(function ($currency) use ($data, $user, $rcon) {
                $updatedCurrencyAmount = collect($data)
                    ->get("currency_{$currency->type}", 0);

                if($updatedCurrencyAmount == $currency->amount) return;

                $rcon->giveCurrency(
                    $user,
                    $currency->type,
                    -$currency->amount + $updatedCurrencyAmount
                );
            });
    }
}
