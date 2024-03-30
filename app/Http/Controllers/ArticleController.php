<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Enums\ArticleReactionType;
use App\Models\AuthorNotification;

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
        $activeArticle = Article::getLatestValidArticle();
        $latestArticlesWithCategories = $this->getLatestArticlesByCategory();

        return view(
            'pages.articles.index',
            compact('latestArticlesWithCategories', 'activeArticle')
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id = null, string $slug = null)
    {
        if (!$activeArticle = Article::fromIdAndSlug($id, $slug)->first()) {
            return redirect()->route('articles.index');
        }

        $activeArticle->syncPaginatedComments();

        return view('pages.articles.index', [
            'latestArticlesWithCategories' => $this->getLatestArticlesByCategory(),
            'activeArticle' => $activeArticle
        ]);
    }

    public function toggleReaction(int $id = null, string $slug = null, Request $request)
    {
        $reactionType = $request->input('type');

        if (!$reactionType || !in_array($reactionType, ArticleReactionType::values())) {
            return $this->jsonResponse([
                'message' => __('Please select a valid reaction type')
            ], 404);
        }

        if (!$activeArticle = Article::fromIdAndSlug($id, $slug, false)->first()) {
            return $this->jsonResponse([
                'message' => __('Article not found')
            ], 404);
        }

        $reaction = $activeArticle->reactions()->firstOrCreate([
            'user_id' => \Auth::id(),
            'type' => $reactionType
        ]);

        if (!$reaction->wasRecentlyCreated) $reaction->delete();

        return $this->jsonResponse([
            'message' => __('Successful!'),
            'href' => route('articles.show', [$activeArticle->id, $activeArticle->slug, '#article-content'])
        ]);
    }

    public function toggleAuthorNotifications(int $id = null, string $slug = null, Request $request)
    {
        if (!$activeArticle = Article::fromIdAndSlug($id, $slug, false)->first()) {
            return $this->jsonResponse([
                'message' => __('Article not found')
            ], 404);
        }

        $notification = AuthorNotification::firstOrCreate([
            'user_id' => \Auth::id(),
            'author_id' => $activeArticle->user->id
        ]);

        if (!$notification->wasRecentlyCreated) {
            $notification->active = !$notification->active;
            $notification->save();
        }

        return $this->jsonResponse([
            'message' => $notification->active || $notification->wasRecentlyCreated
                ? __('You will receive notifications from :a from now on!', ['a' => $activeArticle->user->username])
                : __('You will no longer receive notifications from :a!', ['a' => $activeArticle->user->username])
        ]);
    }

    private function getLatestArticlesByCategory(): array
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
