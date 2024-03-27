<?php

namespace App\Services;

use Illuminate\Support\Facades\App;

/**
 * Stores the cache times for different services. (in seconds)
 */
class CacheTimeService
{
    public static function isLocal(): bool
    {
        return App::isLocal();
    }

    public static function getForHomeWidgetContent(): int
    {
        return self::isLocal() ? 0 : 30;
    }

    public static function getForNavigations(): int
    {
        return self::isLocal() ? 0 : 300;
    }

    public static function getForRankings(): int
    {
        return self::isLocal() ? 0 : 300;
    }

    public static function getForImagePredominantColor(): int
    {
        return self::isLocal() ? 0 : (86400 * 10); // 10 days
    }
}
