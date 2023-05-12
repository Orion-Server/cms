<?php

namespace App\Models\Article;

use App\Models\{
    User,
    Article
};
use Illuminate\Database\Eloquent\{
    Model,
    Relations\BelongsTo,
    Factories\HasFactory
};

class ArticleComment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'visible' => 'boolean',
        'fixed' => 'boolean'
    ];

    public function scopeDefaultRelationships($query): void
    {
        $query->with(['user:id,username,look']);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
