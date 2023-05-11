<?php

namespace App\Http\Controllers\Article;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleReactionController extends Controller
{
    public function __invoke(?string $id = null, ?string $slug = null, string $reactionId)
    {
        if(!\Auth::check()) abort(403);

        $user = \Auth::user();

        if (!$article = Article::fromIdAndSlug($id, $slug)->first()) {
            return $this->returns(false, 'Article not found');
        }

        $reaction = $user->articleReactions()
            ->whereReactionId($reactionId)
            ->whereArticleId($article->id)
            ->first();

        if (!$reaction) {
            $user->articleReactions()->create([
                'article_id' => $article->id,
                'reaction_id' => $reactionId
            ]);

            return $this->returns(true, 'Reaction added');
        }

        $reaction->delete();

        return $this->returns(true, 'Reaction removed');
    }

    public function returns(bool $success, string $message = ''): array
    {
        return [
            'success' => $success,
            'message' => $message
        ];
    }
}
