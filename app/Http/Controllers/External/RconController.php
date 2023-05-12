<?php

namespace App\Http\Controllers\External;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\RconService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class RconController extends Controller
{
    public function followUser(User $user, RconService $rcon)
    {
        if(!config('hotel.rcon.enabled')) {
            return $this->returns(false, 'error', 'RCON is not enabled');
        }

        $follower = \Auth::user();

        if(!$follower->online) {
            return $this->returns(false, 'error', 'You must be online to follow a user');
        }

        if($user->id === $follower->id) {
            return $this->returns(false, 'error', 'You cannot follow yourself');
        }

        if(!$user->online) {
            return $this->returns(false, 'error', 'This user is not online');
        }

        if($user->settings->block_following == '1') {
            return $this->returns(false, 'error', 'This user has blocked following');
        }

        // If the user is a staff player, the follower can only follow if he is a friend
        if($user->rank >= getSetting('min_rank_to_maintenance_login') && $user->friends()->where('user_two_id', $user->id)->doesntExist()) {
            return $this->returns(false, 'error', 'You need to be friends to be able to follow this user');
        }

        $rcon->followUser(\Auth::id(), $user->id);

        return $this->returns(true, 'success', "You followed the user {$user->username}.");
    }

    public function returns(bool $success, string $type, string $message): JsonResponse
    {
        return response()->json([
            'success' => $success,
            'type' => $type,
            'message' => $message
        ], 200);
    }
}
