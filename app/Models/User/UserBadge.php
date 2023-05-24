<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserBadge extends Model
{
    use HasFactory;

    protected $table = 'users_badges';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function badgePath(): Attribute
    {
        return new Attribute(
            get: fn () => getSetting('badges_path') . $this->badge_code . '.gif'
        );
    }
}
