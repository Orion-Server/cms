<?php

namespace App\Actions\Fortify;

use App\Rules\RecaptchaRule;
use Laravel\Fortify\Fortify;
use App\Rules\TurnstileCheck;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable as FortifyRedirectIfTwoFactorAuthenticatable;

class RedirectIfTwoFactorAuthenticatable extends FortifyRedirectIfTwoFactorAuthenticatable
{
    /**
     * Attempt to validate the incoming credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function validateCredentials($request)
    {
        if (Fortify::$authenticateUsingCallback) {
            return tap(call_user_func(Fortify::$authenticateUsingCallback, $request), function ($user) use ($request) {
                if (! $user) {
                    $this->fireFailedEvent($request);

                    $this->throwFailedAuthenticationException($request);
                }
            });
        }

        $model = $this->guard->getProvider()->getModel();

        return tap($model::where(Fortify::username(), $request->{Fortify::username()})->first(), function ($user) use ($request, $model) {
            if (! $user || ! $this->guard->getProvider()->validateCredentials($user, ['password' => $request->password])) {
                $this->fireFailedEvent($request, $user);

                $this->throwFailedAuthenticationException($request);
            }

            if(!! getSetting('maintenance') && $user->rank < getSetting('min_rank_to_maintenance_login')) {
                $this->throwFailedAuthenticationExceptionDuringMaintenance($request);
            }

            $this->validateCaptcha($request->all());

            if (!$user->homeItems()->count()) {
                $user->generateInitialHomeItems();
            }
        });
    }

    /**
     * Throw a failed authentication validation exception.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function throwFailedAuthenticationExceptionDuringMaintenance($request)
    {
        $this->limiter->increment($request);

        throw ValidationException::withMessages([
            Fortify::username() => ['Only staffs can login during maintenance.'],
        ]);
    }

    /**
     * Validate all user data provided from the form.
     *
     * @param array<string, string> $input
     */
    private function validateCaptcha(array $input): void
    {
        $validations = [];

        if(config('hotel.recaptcha.enabled')) {
            $validations['recaptcha'] = ['required', 'string', new RecaptchaRule];
        }

		if(config('hotel.turnstile.enabled')) {
            $validations['cf-turnstile-response'] = ['required', 'string', new TurnstileCheck];
        }

        Validator::make($input, $validations)
            ->stopOnFirstFailure()
            ->validate();
    }
}
