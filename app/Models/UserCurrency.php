<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserCurrency extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'users_currency';

    public $timestamps = false;

    protected $primaryKey = 'user_id';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
