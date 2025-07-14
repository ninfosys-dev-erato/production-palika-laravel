<?php

namespace Src\TokenTracking\DTO;

use Src\TokenTracking\Models\TokenHolder;

class TokenHolderAdminDto
{
   public function __construct(
        public string $name,
        public string $email,
        public string $mobile_no,
        public string $address
    ){}

    public static function fromLiveWireModel(TokenHolder $tokenHolder):TokenHolderAdminDto{
        return new self(
            name: $tokenHolder->name,
            email: $tokenHolder->email??"",
            mobile_no: $tokenHolder->mobile_no??"",
            address: $tokenHolder->address??""
        );
    }
    public static function fromLiveWireArray(array $tokenHolder):TokenHolderAdminDto{
        return new self(
            name: $tokenHolder['name'],
            email: $tokenHolder['email']??"",
            mobile_no: $tokenHolder['mobile_no']??"",
            address: $tokenHolder['address']??""
        );
    }
}
