<?php

namespace App\Http\Controllers\Profile;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\PreventXssService;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function store(string $username, Request $request): JsonResponse
    {
        $data = $request->validate([
            'content' => 'required|string|between:1,500'
        ]);

        if(!$user = User::whereUsername($username)->first()) {
            return $this->jsonResponse([
                'message' => __('User not found.')
            ], 404);
        }

        $authUser = \Auth::user();

        if($authUser->homeMessages()->where('created_at', '>', now()->subMinute())->exists()) {
            return $this->jsonResponse([
                'message' => __('You are sending messages too fast.')
            ], 429);
        }

        $user->myHomeMessages()->create([
            'user_id' => $authUser->id,
            'content' => PreventXssService::sanitize($data['content'])
        ]);

        return $this->jsonResponse([
            'href' => route('users.profile.show', $user->username)
        ]);
    }
}
