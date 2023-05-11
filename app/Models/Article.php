<?php

namespace App\Models;

use App\Models\Article\ArticleReaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'visible' => 'boolean',
        'fixed' => 'boolean',
        'allow_comments' => 'boolean',
        'is_promotion' => 'boolean',
        'promotion_ends_at' => 'datetime'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            $article->user_id = \Auth::id();
            $article->slug = \Str::slug($article->title);
        });
    }

    public static function fromIdAndSlug(string $id, string $slug, bool $withDefaultRelationships = true): Builder
    {
        $query = Article::valid();

        if($withDefaultRelationships) {
            $query->defaultRelationships();
        }

        return $query->whereId($id)
                ->whereSlug($slug);
    }

    public static function getLatestValidArticle(bool $withDefaultRelationships = true): ?Article
    {
        return Article::valid()
            ->when($withDefaultRelationships, fn ($query) => $query->defaultRelationships())
            ->latest()
            ->first();
    }

    public static function forList(int $limit): Builder
    {
        return Article::valid()
            ->select(['id', 'user_id', 'title', 'slug', 'is_promotion', 'promotion_ends_at', 'created_at'])
            ->latest()
            ->limit($limit);
    }

    public function scopeValid($query): void
    {
        $query->whereVisible(true);
    }

    public function scopeDefaultRelationships($query): void
    {
        $query->with([
            'user:id,username,look',
            'tags',
            'reactions' => fn ($query) => $query->with(['user:id,username,look', 'reaction:id,color'])
        ]);
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(ArticleReaction::class)->latest();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
