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

        return view('index', [
            'sliderArticles' => $sliderArticles,
            'fixedArticles' => $fixedArticles,
        ]);
    }
}
