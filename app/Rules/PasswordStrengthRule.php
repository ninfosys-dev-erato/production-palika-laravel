<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PasswordStrengthRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  Closure(string): void  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (strlen($value) < 8) {
            $fail("The $attribute must be at least 8 characters long.");
            return;
        }

        if (!preg_match('/[A-Za-z]/', $value)) {
            $fail("The $attribute must contain at least one letter.");
        }

        if (!preg_match('/[0-9]/', $value)) {
            $fail("The $attribute must contain at least one numeric character.");
        }

        if (!preg_match('/[\W_]/', $value)) { // \W matches any non-word character
            $fail("The $attribute must contain at least one special character.");
        }
    }
}
