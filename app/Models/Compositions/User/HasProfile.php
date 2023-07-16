<?php

namespace App\Models\Compositions\User;

use App\Enums\HomeItemType;
use Illuminate\Support\Facades\DB;
use App\Services\Fillers\FillUserProfile;
use App\Models\Home\{
    HomeItem,
    UserHomeItem
};
use Illuminate\Database\Eloquent\{
    Relations\HasMany
};

trait HasProfile
{
    public function generateInitialHomeItems(): void
    {
        FillUserProfile::forUser($this);
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

    public function groupedInventoryItems(): HasMany
    {
        return $this->inventoryHomeItems()
            ->select(DB::raw('home_item_id, JSON_ARRAYAGG(id) as item_ids'))
            ->groupBy('home_item_id');
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
                'theme' => $item->getDefaultTheme(),
                'created_at' => now(),
                'updated_at' => now()
            ])
        );

        $item->increment('total_bought', $quantity);
    }

    public function changeProfileBackground(UserHomeItem $background): void
    {
        $this->placedHomeItems()
            ->whereHas('homeItem', fn ($query) => $query->whereType(HomeItemType::Background))
            ->update(['placed' => 0]);

        $background->placed = true;
        $background->save();
    }

    public function loadRoomsForProfile(): self
    {
        return $this->load([
            'rooms' => fn ($query) => $query->select('id', 'owner_id', 'name', 'description', 'state')
        ]);
    }

    public function loadGuildsForProfile(): self
    {
        return $this->load([
            'guilds' => fn ($query) => $query->withDefaultRelationships()
        ]);
    }
}
