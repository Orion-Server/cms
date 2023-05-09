<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    private const ARTICLES_LIST_LIMIT = 55;
    private const ARTICLES_LIST_CATEGORIES = [
        'Today' => [],
        'Latest week' => [],
        'Latest month' => [],
        'Latest year' => [],
        'Others' => []
    ];

    public function index(): View
    {
        $latestArticlesWithCategories = $this->getLatestArticlesByCategory();

        return view('pages.articles.index', [
            'latestArticlesWithCategories' => $latestArticlesWithCategories,
            'activeArticle' => Article::valid()->latest()->first()
        ]);
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
            'activeArticle' => $activeArticle
        ]);
    }

    public function getLatestArticlesByCategory(): array
    {
        $latestArticles = Article::forList(self::ARTICLES_LIST_LIMIT)->get();
        $articlesByCategory = self::ARTICLES_LIST_CATEGORIES;

        if ($latestArticles->isEmpty()) return $latestArticles;

        $latestArticles->filter(
            function ($article) use (&$articlesByCategory) {
                $referralCategory = match (true) {
                    $article->created_at->isToday() => 'Today',
                    $article->created_at->isCurrentWeek() => 'Latest week',
                    $article->created_at->isCurrentMonth() => 'Latest month',
                    $article->created_at->isCurrentYear() => 'Latest year',
                    !$article->created_at->isCurrentYear() => 'Others',
                    default => null
                };

                if (!$referralCategory) return false;

                $articlesByCategory[$referralCategory][] = $article;
            }
        );

        return $articlesByCategory;
    }
}
