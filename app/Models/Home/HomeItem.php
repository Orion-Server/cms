<?php

namespace App\Models\Home;

use App\Enums\CurrencyType;
use Illuminate\Database\Eloquent\{
    Model,
    Relations\BelongsTo,
    Factories\HasFactory
};
use Illuminate\Database\Eloquent\Relations\HasMany;

class HomeItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'currency_type' => CurrencyType::class,
        'enabled' => 'boolean'
    ];

    protected $availableWidgets = [
        'My Profile' => 'my-profile',
        'My Friends' => 'my-friends',
        'My Guestbook' => 'my-guestbook',
        'My Badges' => 'my-badges',
        'My Rooms' => 'my-rooms',
        'My Groups' => 'my-groups',
        'My Rating' => 'my-rating'
    ];

    public function homeCategory(): BelongsTo
    {
        return $this->belongsTo(HomeCategory::class);
    }

    public function userHomeItems(): HasMany
    {
        return $this->hasMany(UserHomeItem::class, 'home_item_id');
    }

    public function exceededPurchaseLimit(): bool
    {
        return $this->total_bought >= $this->limit;
    }

    public function getDefaultTheme(): ?string
    {
        if($this->type == 'n') {
            return 'note';
        }

        if($this->type == 'w') {
            return 'default';
        }

        return null;
    }

    public function getAvailableWidgets(): array
    {
        return $this->availableWidgets;
    }
}
