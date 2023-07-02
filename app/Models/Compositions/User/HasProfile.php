<?php

namespace App\Models\Compositions\User;

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
}
