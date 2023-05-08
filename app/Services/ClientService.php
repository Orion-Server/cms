<?php

namespace App\Services;

use App\Models\User;

class ClientService {
    public static function updateAndGetAuthTicket($user = null): string
    {
        if(!$user) $user = \Auth::user();

        $ssoInUse = User::whereAuthTicket(
            $updatedSSO = \Str::uuid()
        )->exists();

        if($ssoInUse) {
            return self::updateAndGetAuthTicket($user);
        }

        $user->update([
            'auth_ticket' => $updatedSSO
        ]);

        return $updatedSSO;
    }
}
