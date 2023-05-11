<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\View\View;
use Illuminate\Http\Request;

class WebController extends Controller
{
    private const ARTICLES_LIST_COUNT = 5;

    public function index(): View
    {
        $sliderArticles = Article::forList(self::ARTICLES_LIST_COUNT)->get();
        $fixedArticles = Article::forList(self::ARTICLES_LIST_COUNT, true)->get();

        $compact = [
            'sliderArticles',
            'fixedArticles'
        ];

        if(\Auth::check()) {
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
