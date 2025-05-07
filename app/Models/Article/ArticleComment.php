<?php

namespace App\Models\Article;

use App\Models\{
    User,
    Article
};
use Illuminate\Database\Eloquent\{
    Model,
    Relations\BelongsTo,
    Factories\HasFactory,
    Builder,
    Casts\Attribute
};

class ArticleComment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'visible' => 'boolean',
        'fixed' => 'boolean',
        'innapropriate' => 'boolean'
    ];

    public function scopeDefaultRelationships(Builder $query): void
    {
        $query->whereVisible(true)->with([
            'user:id,username,look',
            'user.badges' => fn ($query) => $query->where('slot_id', '<>', '0')
        ]);
    }

    public function scopeDefaultBehavior(Builder $query): void
    {
        $query->orderBy('fixed', 'desc')->latest();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function renderedContent(): Attribute
    {
        return new Attribute(
            get: fn() => renderBBCodeText($this->content, true)
        );
    }
}
