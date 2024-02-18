<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Model,
    Builder,
    Collection,
    Relations\BelongsTo,
    Factories\HasFactory
};

class Ban extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    public function scopeValid(Builder $query): void
    {
        $query->where(fn ($query) =>
            $query->where('ban_expire', '>', now()->timestamp)
                  ->orWhere('ban_expire', '0') // permanent
        );
    }

    public static function from(string $ip, bool $verifyAccount = false): ?Collection
    {
        $validPunishments = Ban::where(
                function($query) use ($ip, $verifyAccount) {
                    $query = $query->whereIp($ip);

                    if($verifyAccount) {
                        $query = $query->orWhere('user_id', \Auth::id());
                    }

                    return $query;
                }
            )->latest('id')
             ->valid()
             ->get();

        return $validPunishments;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_staff_id');
    }
}
