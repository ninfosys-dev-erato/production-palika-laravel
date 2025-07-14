<?php

namespace Src\Customers\DTO;

use Src\Customers\Enums\DocumentTypeEnum;
use Src\Customers\Enums\GenderEnum;
use Src\Customers\Enums\KycStatusEnum;
use Src\Customers\Models\Customer;
use Src\Customers\Models\CustomerKyc;

class CustomerAdminDto
{
    public function __construct(
        public ?string $name,
        public ?string $email,
        public ?string $mobile_no,
        public ?string $password,
        public ?GenderEnum $gender,
        public ?string $nepali_date_of_birth,
        public ?string $english_date_of_birth,
        public ?string $grandfather_name,
        public ?string $father_name,
        public ?string $mother_name,
        public ?string $spouse_name,
        public ?int $permanent_province_id,
        public ?int $permanent_district_id,
        public ?int $permanent_local_body_id,
        public ?int $permanent_ward,
        public ?string $permanent_tole,
        public ?int $temporary_province_id,
        public ?int $temporary_district_id,
        public ?int $temporary_local_body_id,
        public ?int $temporary_ward,
        public ?string $temporary_tole,
        public null|string|DocumentTypeEnum $document_type,
        public ?string $document_issued_date_nepali,
        public ?string $document_issued_date_english,
        public ?string $document_issued_at,
        public ?string $document_number,
        public $document_image1,
        public $document_image2, 
        public ?string $expiry_date_nepali,
        public ?string $expiry_date_english,
        public ?string $kyc_verified_at,
        public KycStatusEnum $status
    ) {}

    public static function fromLiveWireModel(Customer $customer, CustomerKyc $kyc): CustomerAdminDto
    {
        return new self(
            name: $customer->name,
            email: $customer->email,
            mobile_no: $customer->mobile_no,
            password: $customer->password,
            gender: $customer->gender,
            nepali_date_of_birth: $kyc->nepali_date_of_birth,
            english_date_of_birth: $kyc->english_date_of_birth,
            grandfather_name: $kyc->grandfather_name,
            father_name: $kyc->father_name,
            mother_name: $kyc->mother_name,
            spouse_name: $kyc->spouse_name,
            permanent_province_id: $kyc->permanent_province_id,
            permanent_district_id: $kyc->permanent_district_id,
            permanent_local_body_id: $kyc->permanent_local_body_id,
            permanent_ward: $kyc->permanent_ward,
            permanent_tole: $kyc->permanent_tole,
            temporary_province_id: $kyc->temporary_province_id,
            temporary_district_id: $kyc->temporary_district_id,
            temporary_local_body_id: $kyc->temporary_local_body_id,
            temporary_ward: $kyc->temporary_ward,
            temporary_tole: $kyc->temporary_tole,
            document_type: $kyc->document_type,
            document_issued_date_nepali: $kyc->document_issued_date_nepali,
            document_issued_date_english: $kyc->document_issued_date_english,
            document_issued_at: $kyc->document_issued_at,
            document_number: $kyc->document_number,
            document_image1: $kyc->document_image1,
            document_image2: $kyc->document_image2,
            expiry_date_nepali: $kyc->expiry_date_nepali,
            expiry_date_english: $kyc->expiry_date_english,
            kyc_verified_at: $kyc->kyc_verified_at ?? null,
            status:  KycStatusEnum::PENDING
        );
    }
    public static function fromAdminLiveWireModel(Customer $customer): CustomerAdminDto
    {
        return new self(
            name: $customer->name,
            email: $customer->email,
            mobile_no: $customer->mobile_no,
            password: $customer->password,
            gender: $customer->gender,
            nepali_date_of_birth: $customer->nepali_date_of_birth,
            english_date_of_birth: $customer->english_date_of_birth,
            grandfather_name: $customer->grandfather_name,
            father_name: $customer->father_name,
            mother_name: $customer->mother_name,
            spouse_name: $customer->spouse_name,
            permanent_province_id: $customer->permanent_province_id,
            permanent_district_id: $customer->permanent_district_id,
            permanent_local_body_id: $customer->permanent_local_body_id,
            permanent_ward: $customer->permanent_ward,
            permanent_tole: $customer->permanent_tole,
            temporary_province_id: $customer->temporary_province_id,
            temporary_district_id: $customer->temporary_district_id,
            temporary_local_body_id: $customer->temporary_local_body_id,
            temporary_ward: $customer->temporary_ward,
            temporary_tole: $customer->temporary_tole,
            document_type: $customer->document_type,
            document_issued_date_nepali: $customer->document_issued_date_nepali,
            document_issued_date_english: $customer->document_issued_date_english,
            document_issued_at: $customer->document_issued_at,
            document_number: $customer->document_number,
            document_image1: $customer->document_image1,
            document_image2: $customer->document_image2,
            expiry_date_nepali: $customer->expiry_date_nepali,
            expiry_date_english: $customer->expiry_date_english,
            kyc_verified_at: date('Y-m-d H:i:s'),
            status: KycStatusEnum::ACCEPTED
        );
    }
}
