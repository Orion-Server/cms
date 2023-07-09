<?php

namespace App\Models\Home;

use Illuminate\Database\Eloquent\{
    Model,
    Builder,
    Factories\HasFactory,
    Relations\BelongsTo
};

class UserHomeItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'placed' => 'boolean',
        'is_reversed' => 'boolean',
        'item_ids' => 'array'
    ];

    public function homeItem(): BelongsTo
    {
        return $this->belongsTo(HomeItem::class);
    }

    public function scopeDefaultRelationships(Builder $query, bool $completeLoading = false): void
    {
        $relation = 'homeItem';

        if(!$completeLoading) {
            $relation .= ':id,type,name,image';
        }

        $query->with($relation);
    }
}
