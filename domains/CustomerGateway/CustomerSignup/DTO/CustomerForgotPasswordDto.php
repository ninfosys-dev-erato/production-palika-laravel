<?php

namespace Domains\CustomerGateway\CustomerSignup\DTO;

class CustomerForgotPasswordDto
{
    public function __construct(
        public readonly string    $mobile_no,

    )
    {
    }

    public static function fromValidatedRequest(array $request): CustomerForgotPasswordDto
    {
        return new self(
            mobile_no: $request['mobile_no']
        );
    }
}
