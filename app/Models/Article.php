<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'visible' => 'boolean',
        'fixed' => 'boolean',
        'allow_comments' => 'boolean'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            $article->user_id = \Auth::id();
            $article->slug = \Str::slug($article->title) . '-' . \Str::random(6);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->morphToMany(CmsTag::class, 'taggable');
    }
}
