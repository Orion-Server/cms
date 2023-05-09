<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
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

    public static function fromIdAndSlug(string $id, string $slug): Builder
    {
        return Article::valid()
            ->defaultRelationships()
            ->whereId($id)
            ->whereSlug($slug);
    }

    public static function forList(int $limit): Builder
    {
        return Article::valid()
            ->defaultRelationships()
            ->latest()
            ->limit($limit);
    }

    public function scopeValid($query): Builder
    {
        return $query->whereVisible(true);
    }

    public function scopeDefaultRelationships($query): Builder
    {
        return $query->with(['user', 'cmsTags']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cmsTags()
    {
        return $this->morphToMany(CmsTag::class, 'taggable');
    }
}
