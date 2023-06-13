<?php

namespace App\Models\User;

use App\Models\{
    Compositions\HasBadge,
    User
};
use Illuminate\Database\Eloquent\{
    Model,
    Relations\BelongsTo,
    Factories\HasFactory
};

class UserBadge extends Model implements HasBadge
{
    use HasFactory;

    protected $table = 'users_badges';

    protected $guarded = [];

    public $timestamps = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getBadgePath(): string
    {
        return getSetting('badges_path') . $this->badge_code . '.gif';
    }

    public function getBadgeName(): string
    {
        return $this->badge_code;
    }
}
