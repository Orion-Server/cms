<?php

namespace App\Models;

use App\Enums\CurrencyType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\{
    Model,
    Relations\BelongsTo,
    Factories\HasFactory
};

class UserCurrency extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'users_currency';

    public $timestamps = false;

    protected $primaryKey = 'user_id';

    public static function getRankingFor(CurrencyType $currency, array $excludeUsersId = [], int $limit = 10): Builder
    {
        $query = UserCurrency::query()
            ->whereType($currency->value)
            ->select(['user_id', 'amount as value'])
            ->whereHas('user')
            ->orderByDesc('amount')
            ->limit($limit)
            ->with(['user:id,username,look']);

        if (!empty($excludeUsersId)) {
            $query->whereNotIn('user_id', $excludeUsersId);
        }

        return $query;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
