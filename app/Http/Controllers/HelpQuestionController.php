<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\HelpQuestion;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\HelpQuestion\HelpQuestionCategory;

class HelpQuestionController extends Controller
{
    public const SEARCH_QUESTIONS_PER_PAGE = 15;

    private const MOST_ASKED_QUESTIONS_LIMIT = 15;
    private const RECENT_ADDED_QUESTIONS_LIMIT = 15;

    public function index(Request $request): View
    {
        if($request->has('search')) {
            return $this->indexSearch($request);
        }

        $categories = HelpQuestionCategory::orderBy('order')->get();

        $addedRecentQuestions = HelpQuestion::latest()
            ->visible()
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

    public function indexSearch(Request $request): View
    {
        $questions = HelpQuestion::visible()
            ->searchBy($request->search)
            ->latest()
            ->paginate(static::SEARCH_QUESTIONS_PER_PAGE);

        return view(
            'pages.support.questions.index',
            compact('questions')
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
