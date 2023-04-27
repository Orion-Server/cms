<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        $this->validateForm($input);

        return User::create([
            'username' => $input['username'],
            'password' => Hash::make($input['password']),
            'mail' => $input['email'],
            'account_created' => time(),
            'last_login' => time(),
            'motto' => 'I Love OrionCMS',
            'look' => 'fa-201407-1324.hr-828-1035.ch-3001-1261-1408.sh-3068-92-1408.cp-9032-1308.lg-270-1281.hd-209-3',
            'credits' => 50000,
            'ip_register' => request()->ip(),
            'ip_current' => request()->ip(),
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
            'username' => ['required', 'string', 'max:25', 'regex:/^([À-üA-Za-z\.:_\-0-9\!]+)$/', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,mail'],
            'password' => $this->passwordRules()
        ];

        return Validator::make($input, $validations)
            ->stopOnFirstFailure()
            ->validate();
    }
}
