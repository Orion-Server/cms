<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\View\View;

class ArticleController extends Controller
{
    private const ARTICLES_LIST_LIMIT = 35;
    private array $articleCategoriesList = [
        'Today' => [],
        'Yesterday' => [],
        'Current week' => [],
        'Last week' => [],
        'Current month' => [],
        'Others' => []
    ];

    public function index(): View
    {
        $latestArticlesWithCategories = $this->getLatestArticlesByCategory();

        $data = [
            'latestArticlesWithCategories' => $latestArticlesWithCategories,
            'activeArticle' => Article::getLatestValidArticle()
        ];

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

        $activeArticle->syncPaginatedComments();

        return view('pages.articles.index', [
            'latestArticlesWithCategories' => $latestArticlesWithCategories,
            'activeArticle' => $activeArticle
        ]);
    }

    public function getLatestArticlesByCategory(): array
    {
        $latestArticles = Article::forIndex(self::ARTICLES_LIST_LIMIT)->get();

        if ($latestArticles->isNotEmpty()) {
            $latestArticles->each(function ($article) {
                $referralCategory = match (true) {
                    $article->created_at->isToday() => 'Today',
                    $article->created_at->isYesterday() => 'Yesterday',
                    $article->created_at->isCurrentWeek() => 'Current week',
                    $article->created_at->isLastWeek() => 'Last week',
                    $article->created_at->isCurrentMonth() => 'Current month',
                    default => 'Others'
                };

                if (!$referralCategory) return;

                array_push($this->articleCategoriesList[$referralCategory], $article);
            });
        }

        return $this->articleCategoriesList;
    }
}
