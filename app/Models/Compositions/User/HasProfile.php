<?php

namespace App\Models\Compositions\User;

use App\Enums\HomeItemType;
use Illuminate\Support\Facades\DB;
use App\Services\Fillers\FillUserProfile;
use App\Models\Home\{
    HomeItem,
    UserHomeItem,
    UserHomeMessage,
    UserHomeRating
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

    public function ratings(): HasMany
    {
        return $this->hasMany(UserHomeRating::class, 'rated_user_id');
    }

    public function myHomeMessages(): HasMany
    {
        return $this->hasMany(UserHomeMessage::class, 'recipient_user_id');
    }

    public function homeMessages(): HasMany
    {
        return $this->hasMany(UserHomeMessage::class, 'user_id');
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
            'rooms' => fn (HasMany $query) => $query->select('id', 'owner_id', 'name', 'description', 'state')
        ]);
    }

    public function loadGuildsForProfile(): self
    {
        return $this->load([
            'guilds' => fn (HasMany $query) => $query->orderByDesc('id')->withDefaultRelationships()
        ]);
    }

    public function loadRatingsForProfile(): self
    {
        $this->profileRating = $this->ratings()
            ->selectRaw('AVG(rating) as rating_avg, COUNT(*) as total, COUNT(IF(rating >= 4, 4, NULL)) as most_posit')
            ->first();

        $this->profileRating->rating_avg = number_format($this->profileRating->rating_avg, 1);

        return $this;
    }

    public function loadFriendsForProfile(): self
    {
        $this->setRelation('friends',
            $this->friends()
                ->defaultFriendData()
                ->orderByDesc('id')
                ->paginate(8, ['*'], 'friends_page')
                ->withPath(route('users.profile.show', $this->username))
        );

        return $this;
    }

    public function loadBadgesForProfile(): self
    {
        $this->setRelation('badges',
            $this->badges()
                ->orderByDesc('id')
                ->paginate(16, ['*'], 'badges_page')
                ->withPath(route('users.profile.show', $this->username))
        );

        return $this;
    }

    public function loadGuestbookForProfile(): self
    {
        return $this->load([
            'myHomeMessages' => fn (HasMany $query) => $query->latest()->defaultUserData()
        ]);
    }
}
