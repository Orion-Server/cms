<?php

namespace App\Enums;

enum CurrencyType: int
{
    case Duckets = 0;
    case Diamonds = 5;
    case Points = 101;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
