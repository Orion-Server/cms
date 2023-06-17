<?php

namespace App\Models;

use App\Models\HelpQuestion\HelpQuestionCategory;
use CyrildeWit\EloquentViewable\{
    Contracts\Viewable,
    InteractsWithViews
};
use Illuminate\Database\Eloquent\{
    Model,
    Builder,
    Factories\HasFactory,
    Relations\BelongsToMany,
    Relations\BelongsTo
};

class HelpQuestion extends Model implements Viewable
{
    use HasFactory, InteractsWithViews;

    protected $guarded = [];

    protected $removeViewsOnDelete = true;

    protected $casts = [
        'visible' => 'boolean'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function (HelpQuestion $question) {
            $question->user_id = \Auth::id();
            $question->slug = \Str::slug($question->title);
        });
    }

    public function scopeVisible(Builder $query): void
    {
        $query->where('visible', true);
    }

    public function scopeSearchBy(Builder $query, ?string $search): void
    {
        $query->where(function(Builder $builder) use ($search): void {
            $builder->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%");
        });
    }

    public static function forPage(int $id, string $slug): Builder
    {
        return HelpQuestion::where('id', $id)
            ->visible()
            ->with('categories')
            ->where('slug', $slug);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(HelpQuestionCategory::class, 'help_question_category');
    }
}
