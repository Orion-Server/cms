<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Model,
    Relations\BelongsTo,
    Factories\HasFactory
};

class MessengerFriendship extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_two_id', 'id');
    }

    public function scopeDefaultFriendData($query): void
    {
        $query->select('user_two_id', 'users.id', 'users.username', 'users.look', 'users.motto', 'users.last_online');
    }
}
