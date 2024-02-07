<?php

namespace App\Models\User;

use App\Enums\ShopOrderStatus;
use App\Models\ShopProduct;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => ShopOrderStatus::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', ShopOrderStatus::Completed);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', ShopOrderStatus::Cancelled);
    }

    public function scopePending($query)
    {
        return $query->where('status', ShopOrderStatus::Pending);
    }

    public function scopeDefaultRelationships($query)
    {
        return $query->with('product');
    }

    public function scopeCompleteRelationships($query)
    {
        return $query->with([
            'product',
            'product.items' => fn ($query) => $query->where('is_active', true)
        ]);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(ShopProduct::class);
    }
}
