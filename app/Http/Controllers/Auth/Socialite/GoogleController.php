<?php

namespace App\Http\Controllers\Auth\Socialite;

use App\Actions\Compositions\HasAuthAttempt;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    use HasAuthAttempt;

    public function handleRedirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();

        if($registeredUser = User::where('mail', $user->getEmail())->first()) {
            Auth::login($registeredUser);

            return redirect()->route('index');
        }

        $userIp = request()->ip();

        $this->treatRegistrationsStatus()
            ->validateClientIp($userIp)
            ->interceptRegistrationsOverflowAttempts($userIp);

        $username = \Str::slug($user->user['given_name']) . random_int(1000, 9999);

        if(strlen($username) > 25) {
            $username = substr($username, 0, 25);
        }

        $registeredUser = User::createFromData([
            'username' => $username,
            'password' => Hash::make(\Str::password(10)),
            'mail' => $user->getEmail(),
            'avatar_background' => $user->getAvatar(),
            'ip_register' => $userIp,
            'ip_current' => $userIp,
            'provider_id' => $user->getId(),
            'gender' => 'M'
        ]);

        if(!$registeredUser) {
            return redirect()->route('login')->with('loginError', __('Something went wrong, please try again later'));
        }

        Auth::login($registeredUser);

        return redirect()->route('index');
    }
}
