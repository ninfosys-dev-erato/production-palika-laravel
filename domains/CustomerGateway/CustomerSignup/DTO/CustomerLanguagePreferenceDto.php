<?php

namespace Domains\CustomerGateway\CustomerSignup\DTO;

class CustomerLanguagePreferenceDto
{
    public function __construct(
        public readonly string    $language_preference,

    )
    {
    }

    public static function fromValidatedRequest(array $request): CustomerLanguagePreferenceDto
    {
        return new self(
            language_preference: $request['language_preference'],
        );
    }
}
