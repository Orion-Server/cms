<?php

namespace App\Models\Compositions\User;

use App\Models\UserCurrency;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasCurrency
{
    private function generateInitialCurrencies(): void
    {
        UserCurrency::insert([
            [
                'user_id' => $this->id,
                'type' => 0,
                'amount' => getSetting('start_duckets'),
            ],
            [
                'user_id' => $this->id,
                'type' => 5,
                'amount' => getSetting('start_diamonds'),
            ],
            [
                'user_id' => $this->id,
                'type' => 101,
                'amount' => getSetting('start_points'),
            ]
        ]);
    }

    public function currencies(): HasMany
    {
        return $this->hasMany(UserCurrency::class);
    }

    public function currency(string $currencyName): int
    {
        if (!$this->relationLoaded('currencies')) {
            $this->load('currencies');
        }

        $type = match ($currencyName) {
            'duckets' => 0,
            'diamonds' => 5,
            'points' => 101
        };

        return $this->currencies->where('type', $type)->first()->amount ?? 0;
    }
}
