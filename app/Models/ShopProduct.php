<?php

namespace App\Models;

use App\Models\User\UserOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class ShopProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(ShopCategory::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(UserOrder::class, 'product_id');
    }

    public function scopeActive($query, bool $considerRank = true)
    {
        if($considerRank && Auth::check() && Auth::user()->rank >= getSetting('min_rank_to_housekeeping_login')) {
            return $query;
        }

        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function items()
    {
        return $this->hasMany(ShopProductItem::class, 'product_id');
    }
}
