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

    public function homeItem(): BelongsTo
    {
        return $this->belongsTo(HomeItem::class);
    }

    public function scopeDefaultRelationships(Builder $query): void
    {
        $query->with('homeItem:id,type,name,image');
    }
}
