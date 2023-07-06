<?php

namespace App\Models\Compositions\User;

use App\Models\Home\HomeItem;
use App\Models\Home\UserHomeItem;
use Illuminate\Database\Eloquent\{
    Relations\HasMany
};

trait HasProfile
{
    private function generateInitialHomeItems(): void
    {
        // TODO: Implement generateInitialHomeItems() method.
    }

    public function homeItems(): HasMany
    {
        return $this->hasMany(UserHomeItem::class);
    }

    public function inventoryHomeItems(): HasMany
    {
        return $this->homeItems()
            ->defaultRelationships()
            ->wherePlaced(0);
    }

    public function placedHomeItems(): HasMany
    {
        return $this->homeItems()
            ->defaultRelationships()
            ->wherePlaced(1);
    }

    public function giveHomeItem(HomeItem $item, int $quantity = 1): void
    {
        $this->homeItems()->insert(
            array_fill(0, $quantity, [
                'user_id' => $this->id,
                'home_item_id' => $item->id,
                'created_at' => now(),
                'updated_at' => now()
            ])
        );

        $item->increment('total_bought', $quantity);
    }
}
