<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class MobileNumberIdentifierRule implements ValidationRule
{
    protected const PATTERNS = [
        '^([9][8][5][0-9]{7})$',
        '^([9][8][46][0-9]{7})$',
        '^([9][7][4-5-6][0-9]{7})$',
        '^([9][8][0-2][0-9]{7})$',
        '^([9][6][0-9]{8}|[9][8][8][0-9]{7})$',
    ];
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $phoneNumber = (string) $value;

        foreach (self::PATTERNS as $pattern) {
            if (preg_match("/$pattern/", $phoneNumber)) {
                return;
            }
        }

        $fail(__("Phone number must be a valid number"));
    }
}
