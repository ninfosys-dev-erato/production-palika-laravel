<?php

namespace Domains\CustomerGateway\CustomerSignup\DTO;

class CustomerPasswordSetDto
{
    public function __construct(
        public readonly string    $mobile_no,
        public readonly string    $password,
        public readonly ?string    $expo_push_token,
        public readonly ?string    $notification_preference,

    )
    {
    }

    public static function fromValidatedRequest(array $request): CustomerPasswordSetDto
    {
        return new self(
            mobile_no: $request['mobile_no'],
            password: $request['password'],
            expo_push_token: $request['expo_push_token'] ?? null,
            notification_preference: $request['notification_preference'] ?? null,

        );
    }
}
