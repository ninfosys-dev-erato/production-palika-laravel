<?php

namespace Domains\CustomerGateway\CustomerDetail\DTO;
use Carbon\Carbon;

class UpdateCustomerDto
{
    public function __construct(
        public string $name,
        public string $email,
        public string $mobile_no,
        public bool $is_active,
        public ?string $avatar,
        public string $gender,
        public ?Carbon $kyc_verified_at = null

    )
    {
    }

    public static function buildFromValidatedRequest(array $request): UpdateCustomerDto
    {
        return new self(
            name: $request['name'],
            email: $request['email'],
            mobile_no: $request['mobile_no'], 
            is_active: $request['is_active'],
            avatar: $request['avatar'] ?? null,
            gender: $request['gender'],
            kyc_verified_at: isset($request['kyc_verified_at']) ? Carbon::parse($request['kyc_verified_at']) : null,
     
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'mobile_no' => $this->mobile_no,
            'is_active' => $this->is_active,
            'avatar' => $this->avatar,
            'gender' => $this->gender,
            'kyc_verified_at' => $this->kyc_verified_at?->toISOString(),
        ];
    }


}
