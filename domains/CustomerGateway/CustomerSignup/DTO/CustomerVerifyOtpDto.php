<?php

namespace Domains\CustomerGateway\CustomerSignup\DTO;

class CustomerVerifyOtpDto
{
    public function __construct(
        public readonly string    $token,
        public readonly string    $otp,

    )
    {
    }

    public static function fromValidatedRequest(array $request): CustomerVerifyOtpDto
    {
        return new self(
            token: $request['token'],
            otp: $request['otp'],

        );
    }
}
