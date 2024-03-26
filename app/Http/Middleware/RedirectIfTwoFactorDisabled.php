<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfTwoFactorDisabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!getSetting('force_housekeeping_two_factor', false)) return $next($request);

        /** @var User $user */
        $user = $request->user();

        if($user->needsEnableTwoFactorAuthentication() || $user->hasIncompleteTwoFactorAuthentication()) {
            return to_route('users.settings.index', '2fa')
                ->with('error', __('You need to enable two-factor authentication to access this page.'));
        }

        return $next($request);
    }
}
