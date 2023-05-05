<?php

namespace App\Services;

use App\Models\User;

class ClientService {
    public static function updateSSO($user): string
    {
        $ssoInUse = User::whereAuthTicket(
            $updatedSSO = \Str::uuid()
        )->exists();

        if($ssoInUse) {
            return self::updateSSO($user);
        }

        $user->update([
            'sso' => $updatedSSO
        ]);
    }
}
