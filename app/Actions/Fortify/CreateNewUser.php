<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Rules\RecaptchaRule;
use App\Rules\TurnstileCheck;
use App\Enums\NotificationType;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Actions\Compositions\HasAuthAttempt;
use App\Models\BetaCode;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, HasAuthAttempt;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        $this->treatRegistrationsStatus()
            ->validateForm($input);

        $userIp = request()->ip();

        $this->validateClientIp($userIp)
            ->interceptRegistrationsOverflowAttempts($userIp);

        return DB::transaction(function () use ($input, $userIp) {
            return tap(User::createFromData([
                'username' => $input['username'],
                'password' => Hash::make($input['password']),
                'mail' => $input['email'],
                'gender' => $input['gender'],
                'ip_register' => $userIp,
                'ip_current' => $userIp,
                'account_day_of_birth' => strtotime($input['birthday']),
                'look' => $input['look'] ?? (getSetting($input['gender'] == 'M' ? 'start_male_look' : 'start_female_look')),
                'beta_code' => !! getSetting('beta_period') ? $input['beta_code'] : null,
            ]), function (User $user) use ($input) {
                if(isset($input['referrer_code'])) {
                    $this->setReferrer($user, $input['referrer_code']);
                }

                if(isset($input['beta_code'])) {
                    $code = BetaCode::whereCode($input['beta_code'])->whereNull('rescued_at')->first();

                    if(!$code) return;

                    $code->update([
                        'rescued_at' => now()
                    ]);
                }
            });
        });
    }

    private function setReferrer(User $user, string $referrerCode): void
    {
        $referrerCodeOwner = User::where('referral_code', $referrerCode)
            ->where(
                fn ($query) => $query->whereNot('ip_register', $user->ip_register)
                    ->whereNot('ip_current', $user->ip_current)
            )->first();

        if(!$referrerCodeOwner) return;

        $referrerCodeOwner->notify($user, NotificationType::ReferrerUser, route('users.profile.show', $user->username));

        $user->update([
            'referrer_code' => $referrerCodeOwner->referral_code
        ]);
    }

    /**
     * Validate all user data provided from the form.
     *
     * @param array<string, string> $input
     */
    private function validateForm(array $input)
    {
        $validations = [
            'username' => ['required', 'string', 'max:25', sprintf('regex:%s', getSetting('register_username_regex')), 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'mail')],
            'gender' => ['required', 'string', 'max:1', Rule::in(['M', 'F'])],
            'referral_code' => ['sometimes', 'string', 'size:15'],
            'birthday' => ['required', 'date', 'before:today', 'after:1924-01-01'],
            'look' => ['nullable', 'string'],
            'password' => $this->passwordRules()
        ];

        if(config('hotel.recaptcha.enabled')) {
            $validations['recaptcha'] = ['required', 'string', new RecaptchaRule];
        }

		if(config('hotel.turnstile.enabled')) {
            $validations['cf-turnstile-response'] = ['required', 'string', new TurnstileCheck];
        }

        if(!! getSetting('beta_period')) {
            $validations['beta_code'] = ['required', 'string', function($attribute, $value, $fail) {
                if(! $key = BetaCode::whereCode($value)->whereNull('rescued_at')->first()) {
                    $fail(__('Beta code not found or already used.'));
                    return;
                }

                if($key->valid_at != null && $key->valid_at->lte(now())) {
                    $fail(__('This beta code has expired.'));
                }
            }];
        }

        try {
            $gender = config('hotel.cms.register.register_looks')[$input['gender']];

            array_push($validations['look'], Rule::in($gender));
        } catch (\Throwable $ignored) {}

        return Validator::make($input, $validations)
            ->stopOnFirstFailure()
            ->validate();
    }
}
