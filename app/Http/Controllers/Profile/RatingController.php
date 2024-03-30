<?php

namespace App\Http\Controllers\Profile;

use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\NotificationType;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class RatingController extends Controller
{
    public function store(string $username, Request $request): JsonResponse
    {
        $data = $request->validate([
            'rating' => 'required|integer|between:1,5'
        ]);

        if(!$user = User::whereUsername($username)->first()) {
            return $this->jsonResponse([
                'message' => __('User not found.')
            ], 404);
        }

        if($user->id === \Auth::id()) {
            return $this->jsonResponse([
                'message' => __('You cannot rate your own profile.')
            ], 400);
        }

        $rating = $user->ratings()->updateOrCreate(['user_id' => \Auth::id()], [
            'rating' => $data['rating']
        ]);

        if($rating->wasRecentlyCreated) {
            $user->notify(\Auth::user(), NotificationType::ProfileRating, route('users.profile.show', $user->username));
        }

        return $this->jsonResponse([
            'href' => route('users.profile.show', $user->username)
        ]);
    }
}
