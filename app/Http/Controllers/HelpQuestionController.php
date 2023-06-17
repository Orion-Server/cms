<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\HelpQuestion;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\HelpQuestion\HelpQuestionCategory;

class HelpQuestionController extends Controller
{
    private const MOST_ASKED_QUESTIONS_LIMIT = 15;
    private const RECENT_ADDED_QUESTIONS_LIMIT = 15;

    public function index(): View
    {
        $categories = HelpQuestionCategory::orderBy('order')->get();

        $addedRecentQuestions = HelpQuestion::latest()
            ->limit(static::RECENT_ADDED_QUESTIONS_LIMIT)
            ->get();

        $mostAskedQuestions = HelpQuestion::orderByUniqueViews()
            ->whereHas('views')
            ->limit(static::MOST_ASKED_QUESTIONS_LIMIT)
            ->get();

        return view(
            'pages.support.questions.index',
            compact('categories', 'addedRecentQuestions', 'mostAskedQuestions')
        );
    }

    public function show(int $id, string $slug): RedirectResponse|View
    {
        if (! $question = HelpQuestion::forPage($id, $slug)->first()) {
            return redirect()->route('support.questions.index');
        }

        views($question)->record();

        return view('pages.support.questions.show', compact('question'));
    }

    public function category(string $slug, Request $request): RedirectResponse|View
    {
        if (! $category = HelpQuestionCategory::forPage($slug)->first()) {
            return redirect()->route('support.questions.index');
        }

        $category->syncPaginatedQuestions($request);

        return view('pages.support.questions.categories.show', compact('category'));
    }
}
