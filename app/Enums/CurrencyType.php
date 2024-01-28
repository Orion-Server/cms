<?php

namespace App\Enums;

enum CurrencyType: int
{
    case Credits = -1;
    case Duckets = 0;
    case Diamonds = 5;
    case Points = 101;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function fromCurrencyName(string $currencyName): ?self
    {
        $currencyName = strtolower($currencyName);

        $currency = match ($currencyName) {
            'credits' => self::Credits,
            'duckets' => self::Duckets,
            'diamonds' => self::Diamonds,
            'points' => self::Points,
            default => null,
        };

        return $currency;
    }

    public static function toInput(): array
    {
        $allCurrencies = self::cases();

        return array_combine(
            array_column($allCurrencies, 'value'),
            array_column($allCurrencies, 'name'),
        );
    }
}
