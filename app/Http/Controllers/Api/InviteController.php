<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;

class InviteController extends Controller
{
    public function getReferralUsername($referralCode): array
    {
        $referralUser = User::where('referral_code', $referralCode)
            ->select(['username', 'referral_code'])
            ->first();

        if(!$referralUser) return response()->json(['error' => 'Referral code not found'], 404);

        return [
            'username' => $referralUser->username,
            'referral_code' => $referralUser->referral_code
        ];
    }
}
