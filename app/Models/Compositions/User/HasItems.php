<?php

namespace App\Models\Compositions\User;

use App\Models\UserSetting;
use App\Models\User\UserItem;
use App\Models\ItemDefinition;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasItems
{
    public function addItem(ItemDefinition $item, int $quantity = 1): void
    {
        $items = [];

        for($i = 0; $i < $quantity; $i++) {
            $items[] = [
                'user_id' => $this->id,
                'item_id' => $item->id,
                'room_id' => 0
            ];
        }

        $this->items()->insert($items);
    }
}
