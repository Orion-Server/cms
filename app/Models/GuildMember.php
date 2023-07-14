<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GuildMember extends Model
{
    use HasFactory;

    public $table = 'guilds_members';

    public function scopeWithDefaultRelationships(Builder $query): Builder
    {
        return $query->with([
            'guild' => fn ($query) => $query->select('id' , 'name', 'date_created', 'badge')
        ]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function guild(): BelongsTo
    {
        return $this->belongsTo(Guild::class);
    }
}
