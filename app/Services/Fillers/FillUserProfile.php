<?php

namespace App\Services\Fillers;

use App\Models\User;
use App\Enums\HomeItemType;
use App\Models\Home\HomeItem;

class FillUserProfile
{
    /**
     * - Default home items:
     *  1. The first background in the home_items table,
     *  2. The first widget in the home_items table
     */
    public static function getDefaultUserItems(User $user): array
    {
        $items = [];

        if($user->homeItems()->exists()) return $items;

        $defaultBackground = HomeItem::whereType(HomeItemType::Background)->first();
        $defaultWidget = HomeItem::whereType(HomeItemType::Widget)->first();

        if($defaultBackground) {
            $items[] = [
                'user_id' => $user->id,
                'home_item_id' => $defaultBackground->id,
                'x' => 0,
                'y' => 0,
                'z' => 0,
                'placed' => true,
                'theme' => null,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        if($defaultWidget) {
            $items[] = [
                'user_id' => $user->id,
                'home_item_id' => $defaultWidget->id,
                'x' => 500,
                'y' => 150,
                'z' => 0,
                'placed' => true,
                'theme' => 'default',
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        return $items;
    }

    public static function forUser(User $user)
    {
        $user->homeItems()->insert(
            self::getDefaultUserItems($user)
        );
    }
}
