<?php

namespace App\Models\Home;

use App\Models\User;
use Illuminate\Database\Eloquent\{
    Builder,
    Model,
    Relations\BelongsTo,
    Factories\HasFactory,
    Casts\Attribute
};

class UserHomeMessage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function recipientUser(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeDefaultUserData(Builder $query): void
    {
        $query->with(['user:id,username,look,online']);
    }

    public function renderedContent(): Attribute
    {
        return new Attribute(
            get: fn() => renderBBCodeText($this->content, true)
        );
    }
}
