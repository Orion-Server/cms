<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Camera;
use App\Models\User;
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

        $defaultArticles = Article::forIndex(
            $this->getArticlesLimit('default', $isAuthenticated)
        )->whereFixed(false)->get();

        $fixedArticles = Article::forIndex(
            $this->getArticlesLimit('fixed', $isAuthenticated)
        )->whereFixed(true)->get();

        $compactValues = ['defaultArticles', 'fixedArticles'];

        if ($isAuthenticated) {
            $onlineFriends = \Auth::user()->getOnlineFriends();
            $referredUsersCount = \Auth::user()->referredUsers()->count();

            array_push($compactValues, 'onlineFriends', 'referredUsersCount');
        } else {
            $photos = Camera::latestWith()->get();
            $latestUsers = User::forIndex()->get();

            array_push($compactValues, 'photos', 'latestUsers');
        }

        return view('index', compact($compactValues));
    }

    private function getArticlesLimit(string $type, bool $isAuthenticated): int
    {
        if($type == 'default') return match ($isAuthenticated) {
            true => self::ARTICLES_LIST_COUNT_WHEN_AUTH,
            false => self::ARTICLES_LIST_COUNT_WHEN_GUEST
        };

        if($type == 'fixed') return match ($isAuthenticated) {
            true => self::FIXED_ARTICLES_LIST_COUNT_WHEN_AUTH,
            false => self::FIXED_ARTICLES_LIST_COUNT_WHEN_GUEST
        };

        return 0;
    }
}
