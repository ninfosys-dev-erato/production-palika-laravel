<?php

namespace Domains\CustomerGateway\CustomerSignup\DTO;

class CustomerSignUpDto
{
    public function __construct(
        public readonly string    $mobile_no,

    )
    {
    }

    public static function fromValidatedRequest(array $request): CustomerSignUpDto
    {
        return new self(
            mobile_no: $request['mobile_no'],
        );
    }
}
