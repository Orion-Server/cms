<?php

namespace App\Enums;

enum ShopOrderStatus: string
{
    case Pending = 'pending';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function valuesExcept(ShopOrderStatus $exceptValue = null): array
    {
        return array_filter(self::values(), fn ($value) => $value !== $exceptValue->value);
    }
}
