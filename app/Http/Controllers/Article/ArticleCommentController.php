<?php

namespace App\Http\Controllers\Article;

use App\Enums\NotificationType;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\PreventXssService;

class ArticleCommentController extends Controller
{
    public function store(string $id, string $slug, Request $request): JsonResponse
    {
        $data = $request->validate([
            'content' => 'required|string'
        ]);

        if (!$article = Article::fromIdAndSlug($id, $slug)->first()) {
            return $this->jsonResponse(['message' => __('Article not found')], 404);
        }

        $user = \Auth::user();

        if($user->recentlyCommentedOnArticle() && !$user->hasHighPermissions()) {
            return $this->jsonResponse(['message' => __('You are commenting too fast')], 422);
        }

        if(strlen(preg_replace("/\[(\/?).*?\]/", '', $data['content'])) < 5) {
            return $this->jsonResponse(['message' => __('Please, type a valid comment.')], 422);
        }

        $comment = $article->comments()->create([
            'content' => PreventXssService::sanitize($data['content']),
            'user_id' => $user->id
        ]);

        $article->user->notify($user, NotificationType::ArticleCommented, route('articles.show', ['id' => $article->id, 'slug' => $article->slug]));

        return $this->jsonResponse([
            'comment' => $comment,
            'message' => __('Comment created successfully'),
            'href' => route('articles.show', ['id' => $article->id, 'slug' => $article->slug]) . '#comments'
        ]);
    }
}
