<?php

namespace App\Models\HelpQuestion;

use App\Http\Controllers\HelpQuestionController;
use App\Models\HelpQuestion;
use Illuminate\Database\Eloquent\{
    Builder,
    Model,
    Factories\HasFactory,
    Relations\BelongsToMany
};
use Illuminate\Http\Request;

class HelpQuestionCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function (HelpQuestionCategory $category) {
            $category->slug = \Str::slug($category->name);
        });

        static::updating(function (HelpQuestionCategory $category) {
            $category->slug = \Str::slug($category->name);
        });
    }

    public function syncPaginatedQuestions(Request $request): void
    {
        $query = $this->questions()
            ->visible();

        if($request->has('search')) {
            $query->searchBy($request->search);
        }

        $this->setRelation('questions', $query->paginate(HelpQuestionController::SEARCH_QUESTIONS_PER_PAGE));
    }

    public static function forPage(string $slug): Builder
    {
        return HelpQuestionCategory::query()
            ->where('slug', $slug);
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(HelpQuestion::class, 'help_question_category');
    }
}
