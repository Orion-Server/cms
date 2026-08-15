<?php

namespace App\Rules;

use Illuminate\Translation\PotentiallyTranslatedString;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Coderflex\LaravelTurnstile\Facades\LaravelTurnstile;

class TurnstileCheck implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string):PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!config('hotel.turnstile.enabled')) return;

        $response = LaravelTurnstile::validate($value);

        if(! $response['success']) $fail(__('auth.turnstile_failed'));
    }
}
