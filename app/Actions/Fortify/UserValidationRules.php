<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Rules\Password;
use Laravel\Jetstream\Jetstream;

trait UserValidationRules
{
    use PasswordValidationRules;
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function rules($include_password = true, $email_unique = true)
    {
        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', $email_unique ? 'unique:users' : ''],
            'district' => ['required', 'exists:districts,id'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ];

        if ($include_password) $rules['password'] = $this->passwordRules();

        return $rules;
    }
}
