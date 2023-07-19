<?php

namespace App\Services\Profile;

use App\Models\User;
use App\Models\Home\UserHomeItem;

trait InteractWithWidgets
{
    public function getWidgetContent(User $user, UserHomeItem $item): ?string
    {
        $viewName = "components.home.items.widgets.{$item->widget_type}";

        if (! view()->exists($viewName)) return null;

        $user = match ($item->widget_type) {
            'my-groups' => $user->loadGuildsForProfile(),
            'my-rooms' => $user->loadRoomsForProfile(),
            'my-badges' => $user->loadBadgesForProfile(),
            'my-friends' => $user->loadFriendsForProfile(),
            default => $user
        };

        return view($viewName, compact('item', 'user'))->render();
    }
}
