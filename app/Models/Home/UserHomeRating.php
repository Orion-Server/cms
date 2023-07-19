<?php

namespace App\Models\Home;

use App\Models\User;
use Illuminate\Database\Eloquent\{
    Model,
    Relations\BelongsTo,
    Factories\HasFactory
};

class UserHomeRating extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ratedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rated_user_id');
    }
}
