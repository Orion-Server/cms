<?php

namespace App\Http\Controllers\Article;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ArticleCommentController extends Controller
{
    public function store(string $id, string $slug, Request $request): JsonResponse
    {
        $data = $request->validate([
            'content' => 'required|string|min:5'
        ]);

        if (!$article = Article::fromIdAndSlug($id, $slug)->first()) {
            return $this->jsonResponse(['message' => __('Article not found')], 404);
        }

        $user = \Auth::user();

        if($user->recentlyCommentedOnArticle()) {
            return $this->jsonResponse(['message' => __('You are commenting too fast')], 422);
        }

        $comment = $article->comments()->create([
            'content' => strip_tags($data['content']),
            'user_id' => $user->id
        ]);

        return $this->jsonResponse([
            'comment' => $comment,
            'message' => __('Comment created successfully'),
            'href' => route('articles.show', ['id' => $article->id, 'slug' => $article->slug])
        ]);
    }
}
