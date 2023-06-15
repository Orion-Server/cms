<?php

namespace App\Http\Controllers;

use App\Models\HelpQuestion;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\HelpQuestion\HelpQuestionCategory;

class HelpQuestionController extends Controller
{
    private const MOST_ASKED_QUESTIONS_LIMIT = 15;
    private const RECENT_ADDED_QUESTIONS_LIMIT = 15;

    public function index(): View
    {
        $categories = HelpQuestionCategory::orderBy('order')->get();

        $recentAddedQuestions = HelpQuestion::latest()
            ->limit(static::RECENT_ADDED_QUESTIONS_LIMIT)
            ->get();

        $mostAskedQuestions = HelpQuestion::orderByDesc('views')
            ->limit(static::MOST_ASKED_QUESTIONS_LIMIT)
            ->get();

        return view(
            'pages.support.questions.index',
            compact('categories', 'recentAddedQuestions', 'mostAskedQuestions')
        );
    }
}
