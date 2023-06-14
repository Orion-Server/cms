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

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(HelpQuestion::class, 'help_question_category');
    }
}
