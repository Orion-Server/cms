<?php

namespace App\Models\HelpQuestion;

use App\Models\HelpQuestion;
use Illuminate\Database\Eloquent\{
    Model,
    Factories\HasFactory,
    Relations\BelongsToMany
};

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

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(HelpQuestion::class, 'help_question_category');
    }
}
