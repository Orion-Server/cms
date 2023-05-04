<?php

namespace App\Helpers;

use App\Models\User;

class ClientHelper {
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
