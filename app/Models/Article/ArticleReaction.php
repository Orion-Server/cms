<?php

namespace App\Models\Article;

use App\Enums\ArticleReactionType;
use App\Models\{
    Article,
    User
};
use Illuminate\Database\Eloquent\{
    Builder,
    Model,
    Relations\BelongsTo,
    Factories\HasFactory
};

class ArticleReaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'type' => ArticleReactionType::class
    ];

    public function scopeDefaultRelationships(Builder $query): void
    {
        $query->with([
            'user' => fn ($query) => $query->select(['id', 'username', 'look'])
        ]);
    }

    public function scopeDefaultBehavior(Builder $query): void
    {
        $query->latest();
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
