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
        if($currency->value === CurrencyType::Credits->value) return $this->credits;

        if (!$this->relationLoaded('currencies')) {
            $this->load('currencies');
        }

        return $this->currencies
            ->where('type', $currency->value)
            ->first()
            ->amount ?? 0;
    }

    public function discountCurrency(CurrencyType $currency, int $amount): void
    {
        if($currency === CurrencyType::Credits) {
            $this->decrement('credits', $amount);
            return;
        }

        $this->currencies()
            ->whereType($currency->value)
            ->decrement('amount', $amount);
    }

    public function incrementCurrency(CurrencyType $currency, int $amount): void
    {
        if($currency === CurrencyType::Credits) {
            $this->increment('credits', $amount);
            return;
        }

        $this->currencies()
            ->whereType($currency->value)
            ->increment('amount', $amount);
    }
}
