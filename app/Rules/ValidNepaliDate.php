<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidNepaliDate implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  Closure  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^\d{4}[-\/]\d{1,2}[-\/]\d{1,2}$/', $value)) {
            $fail('The ' . $attribute . ' must be a valid date format (YYYY-MM-DD or YYYY/MM/DD).');
            return;
        }
    }

    public function message()
    {
        return 'The :attribute is not a valid Nepali date.';
    }
}
