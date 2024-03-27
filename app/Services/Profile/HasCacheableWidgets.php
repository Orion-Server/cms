<?php

namespace App\Services\Profile;

use App\Models\User;
use App\Models\Home\UserHomeItem;
use App\Services\CacheTimeService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

trait HasCacheableWidgets
{
    public function getCacheableWidgetData(User $user, UserHomeItem $item): User
    {
        $cacheKey = $this->getWidgetContentCacheKey($user, $item);
        $cacheableTime = CacheTimeService::getForHomeWidgetContent();

        if(in_array($item->widget_type, ['my-rating', 'my-guestbook'])) $cacheableTime = 0;

        return Cache::remember($cacheKey, $cacheableTime, fn () => match ($item->widget_type) {
            'my-groups' => $user->loadGuildsForProfile(),
            'my-rooms' => $user->loadRoomsForProfile(),
            'my-badges' => $user->loadBadgesForProfile(),
            'my-friends' => $user->loadFriendsForProfile(),
            'my-rating' => $user->loadRatingsForProfile(),
            'my-guestbook' => $user->loadGuestbookForProfile(),
            default => $user
        });
    }

    public function clearWidgetContentCache(User $user, UserHomeItem $widget): void
    {
        Cache::forget($this->getWidgetContentCacheKey($user, $widget));
    }

    public function getWidgetContentCacheKey(User $user, UserHomeItem $widget): string
    {
        return "user_{$user->id}_widget_{$widget->id}_content";
    }
}
