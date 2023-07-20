<?php

namespace App\Http\Controllers\External;

use App\Models\User;
use App\Services\RconService;
use App\Http\Controllers\Controller;

class RconController extends Controller
{
    public function followUser(User $user, RconService $rcon)
    {
        if(!config('hotel.rcon.enabled')) {
            return $this->externalJsonResponse('error', 'RCON is not enabled');
        }

        $follower = \Auth::user();

        if(!$follower->online) {
            return $this->externalJsonResponse('error', 'You must be online to follow a user');
        }

        if($user->id === $follower->id) {
            return $this->externalJsonResponse('error', 'You cannot follow yourself');
        }

        if(!$user->online) {
            return $this->externalJsonResponse('error', 'This user is not online');
        }

        if($user->settings->block_following == '1') {
            return $this->externalJsonResponse('error', 'This user has blocked following');
        }

        // If the user is a staff player, the follower can only follow if he is a friend
        if($user->rank >= getSetting('min_rank_to_maintenance_login') && $user->friends()->where('user_two_id', $user->id)->doesntExist()) {
            return $this->externalJsonResponse('error', 'You need to be friends to be able to follow this user');
        }

        $rcon->followUser(\Auth::id(), $user->id);

        return $this->externalJsonResponse('success', "You followed the user {$user->username}.");
    }
}
