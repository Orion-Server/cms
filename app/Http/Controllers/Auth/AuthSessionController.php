<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

class AuthSessionController extends AuthenticatedSessionController
{
    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Fortify\Contracts\LogoutResponse
     */
    public function destroy(Request $request): LogoutResponse
    {
        $locale = session()->get('locale', null);

        $this->guard->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if (!empty($locale)) {
            session()->put('locale', $locale);
        }

        return app(LogoutResponse::class);
    }
}
