<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class VerifyLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = Session::get('locale');
        $availableLanguages = array_keys(config('hotel.cms.available_languages'));

        if (!$locale) {
            $locale = $request->getPreferredLanguage($availableLanguages);
        }

        if ($locale && in_array($locale, $availableLanguages)) {
            App::setLocale($locale);
            session()->put('locale', $locale);
        }

        return $next($request);
    }
}
