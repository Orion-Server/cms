<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\View\View;

class WebController extends Controller
{
    private const FIXED_ARTICLES_LIST_COUNT_WHEN_AUTH = 5;
    private const FIXED_ARTICLES_LIST_COUNT_WHEN_GUEST = 4;

    private const ARTICLES_LIST_COUNT_WHEN_AUTH = 5;
    private const ARTICLES_LIST_COUNT_WHEN_GUEST = 6;

    public function index(): View
    {
        $isAuthenticated = \Auth::check();

        $articlesListCount = match($isAuthenticated) {
            true => self::ARTICLES_LIST_COUNT_WHEN_AUTH,
            false => self::ARTICLES_LIST_COUNT_WHEN_GUEST
        };

        $fixedArticlesListCount = match($isAuthenticated) {
            true => self::FIXED_ARTICLES_LIST_COUNT_WHEN_AUTH,
            false => self::FIXED_ARTICLES_LIST_COUNT_WHEN_GUEST
        };

        $defaultArticles = Article::forIndex($articlesListCount)->get();
        $fixedArticles = Article::forIndex($fixedArticlesListCount, true)->get();

        $compact = [
            'defaultArticles',
            'fixedArticles'
        ];

        if($isAuthenticated) {
            $onlineFriends = \Auth::user()->getOnlineFriends();
            $referredUsersCount = \Auth::user()->referredUsers()->count();

            $compact = array_merge($compact, [
                'onlineFriends',
                'referredUsersCount'
            ]);
        }

        return view('index', compact($compact));
    }
}
