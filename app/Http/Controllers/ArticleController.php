<?php

namespace App\Http\Controllers;

use App\Models\{Article, Reaction};
use Illuminate\View\View;

class ArticleController extends Controller
{
    private const ARTICLES_LIST_LIMIT = 35;
    private const ARTICLES_LIST_CATEGORIES = [
        'Today' => [],
        'Yesterday' => [],
        'Current week' => [],
        'Last week' => [],
        'Current month' => []
    ];

    public function index(): View
    {
        $latestArticlesWithCategories = $this->getLatestArticlesByCategory();

        $data = [
            'latestArticlesWithCategories' => $latestArticlesWithCategories,
            'activeArticle' => Article::getLatestValidArticle()
        ];

        if($data['activeArticle']) {
            $data['allReactions'] = Reaction::all();
        }

        return view('pages.articles.index', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(?string $id = null, ?string $slug = null)
    {
        $latestArticlesWithCategories = $this->getLatestArticlesByCategory();

        if (!$activeArticle = Article::fromIdAndSlug($id, $slug)->first()) {
            return redirect()->route('articles.index');
        }

        return view('pages.articles.index', [
            'latestArticlesWithCategories' => $latestArticlesWithCategories,
            'activeArticle' => $activeArticle,
            'allReactions' => Reaction::all()
        ]);
    }

    public function getLatestArticlesByCategory(): array
    {
        $latestArticles = Article::forList(self::ARTICLES_LIST_LIMIT)->get();
        $articlesByCategory = self::ARTICLES_LIST_CATEGORIES;

        if ($latestArticles->isEmpty()) return $articlesByCategory;

        $latestArticles->filter(
            function ($article) use (&$articlesByCategory) {
                $referralCategory = match (true) {
                    $article->created_at->isToday() => 'Today',
                    $article->created_at->isYesterday() => 'Yesterday',
                    $article->created_at->isCurrentWeek() => 'Current week',
                    $article->created_at->isLastWeek() => 'Last week',
                    !$article->created_at->isCurrentMonth() => 'Current month',
                    default => null
                };

                if (!$referralCategory) return false;

                $articlesByCategory[$referralCategory][] = $article;
            }
        );

        return $articlesByCategory;
    }
}
