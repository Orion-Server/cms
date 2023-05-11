<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reaction extends Model
{
    use HasFactory;

    public function articleReactions(): HasMany
    {
        return $this->hasMany(ArticleReaction::class);
    }

    public function completeIconPath(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $this->icon ? asset('assets/images/reactions/' . $this->icon) : null,
        );
    }
}
