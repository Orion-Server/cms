<?php

namespace App\Enums;

enum HomeItemType: string
{
    case Sticker = 's';
    case Note = 'n';
    case Widget = 'w';
    case Background = 'b';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function valuesExcept(HomeItemType $exceptValue = null): array
    {
        return array_filter(self::values(), fn ($value) => $value !== $exceptValue->value);
    }
}
