<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Features;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use App\Actions\Fortify\RedirectIfTwoFactorAuthenticatable;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::confirmPasswordView(fn () => view('pages.auth.confirm-password'));
        Fortify::twoFactorChallengeView(fn () => view('pages.auth.two-factor-challenge'));

        Fortify::authenticateThrough(function(): array {
            $through = [
                AttemptToAuthenticate::class,
                PrepareAuthenticatedSession::class
            ];

            if(Features::enabled(Features::twoFactorAuthentication())) {
                array_unshift($through, RedirectIfTwoFactorAuthenticatable::class);
            }

            if(! config('fortify.limiters.login')) {
                array_unshift($through, EnsureLoginIsNotThrottled::class);
            }

            return $through;
        });

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email.$request->ip());
        });

        RateLimiter::for('two-factor',
            fn (Request $request) => Limit::perMinute(5)->by($request->session()->get('login.id'))
        );
    }
}
