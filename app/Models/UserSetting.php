<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\{
    Model,
    Factories\HasFactory,
    Relations\BelongsTo
};

class UserSetting extends Model
{
    use HasFactory;

    protected $table = 'users_settings';

    protected $guarded = [];

    public $timestamps = false;

    public static function getRanking(string $rankingType, array $excluseUsersId = [], int $limit = 10): Builder
    {
        if (!in_array($rankingType, ['respects_received', 'online_time'])) return null;

        return UserSetting::query()
            ->select(['user_id', "{$rankingType} as value"])
            ->whereNotIn('user_id', $excluseUsersId)
            ->whereHas('user')
            ->orderByDesc($rankingType)
            ->limit($limit)
            ->with(['user:id,username,look']);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
