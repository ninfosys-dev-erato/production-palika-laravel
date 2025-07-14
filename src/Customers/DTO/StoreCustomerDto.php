<?php

namespace Domains\CustomerDetail\DTO;
use Carbon\Carbon;

class StoreCustomerDto
{
    public function __construct(
        public string $customer_id,
        public string $name,
        public string $email,
        public string $mobile_no,
        public bool $is_active,
        public ?string $avatar,
        public string $gender,
        public ?int $created_by = null,
        public ?int $updated_by = null,
        public ?int $deleted_by = null,
        public ?Carbon $kyc_verified_at = null

    )
    {
    }

    public static function buildFromValidatedRequest(array $request): StoreCustomerDto
    {
        return new self(
            customer_id: $request['customer_id'],
            name: $request['name'],
            email: $request['email'],
            mobile_no: $request['mobile_no'],
            is_active: $request['is_active'],
            avatar: $request['avatar'] ?? null,
            gender: $request['gender'],
            created_by: $request['created_by'] ?? null,
            updated_by: $request['updated_by'] ?? null,
            deleted_by: $request['deleted_by'] ?? null,
            kyc_verified_at: isset($request['kyc_verified_at']) ? Carbon::parse($request['kyc_verified_at']) : null,
     
        );
    }

    public function toArray(): array
    {
        return [
            'customer_id' => $this->customer_id,
            'name' => $this->name,
            'email' => $this->email,
            'mobile_no' => $this->mobile_no,
            'is_active' => $this->is_active,
            'avatar' => $this->avatar,
            'gender' => $this->gender,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
            'kyc_verified_at' => $this->kyc_verified_at?->toISOString(),
        ];
    }


}
