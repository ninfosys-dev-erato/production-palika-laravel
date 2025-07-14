<?php

namespace Domains\CustomerGateway\CustomerSignup\DTO;

class CustomerResentOtpDto
{
    public function __construct(
        public readonly string    $mobile_no,

    )
    {
    }

    public static function fromValidatedRequest(array $request): CustomerResentOtpDto
    {
        return new self(
            mobile_no: $request['mobile_no']
        );
    }
}
