<?php

namespace App\Models\Compositions\User;

use App\Enums\CurrencyType;
use App\Models\UserCurrency;
use Illuminate\Database\Eloquent\{
    Builder,
    Relations\HasMany
};

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

    public function scopeWithCurrencies(Builder $query): void
    {
        $query->with(['currencies']);
    }

    public function currencies(): HasMany
    {
        return $this->hasMany(UserCurrency::class);
    }

    public function currency(CurrencyType $currency): int
    {
        if (!$this->relationLoaded('currencies')) {
            $this->load('currencies');
        }

        return $this->currencies
            ->where('type', $currency->value)
            ->first()
            ->amount ?? 0;
    }
}
