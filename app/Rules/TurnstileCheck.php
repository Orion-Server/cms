<?php

namespace App\Rules;

use Coderflex\LaravelTurnstile\Facades\LaravelTurnstile;
use Illuminate\Contracts\Validation\Rule;

class TurnstileCheck implements Rule
{
    public function passes($attribute, $value)
    {
        if (!config('hotel.turnstile.enabled')) {
            return true;
        }

        $response = LaravelTurnstile::validate($value);
        return $response['success'];
    }

    public function message()
    {
        return __('auth.recaptcha_failed');
    }
}