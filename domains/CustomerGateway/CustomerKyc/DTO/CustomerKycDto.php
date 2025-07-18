<?php

namespace Domains\CustomerGateway\CustomerKyc\DTO;

class CustomerKycDto
{
    public function __construct(
        public readonly ?string $name, 
        public readonly ?string $email, 
        public readonly ?string $gender, 
        public readonly ?string $grandfather_name, 
        public readonly ?string $father_name, 
        public readonly ?string $mother_name, 
        public readonly ?string $spouse_name, 
        public readonly ?string $nepali_date_of_birth, 
        public readonly ?string $english_date_of_birth, 
        public readonly ?int $permanent_province_id,
        public readonly ?int $permanent_district_id,
        public readonly ?int $permanent_local_body_id,
        public readonly ?string $permanent_ward,
        public readonly ?string $permanent_tole,
        public readonly ?int $temporary_province_id,
        public readonly ?int $temporary_district_id,
        public readonly ?int $temporary_local_body_id,
        public readonly ?string $temporary_ward,
        public readonly ?string $temporary_tole,
        public readonly ?string $document_type,
        public readonly ?string $document_issued_date_nepali,
        public readonly ?string $document_issued_date_english,
        public readonly ?int $document_issued_at,
        public readonly ?string $document_number,
        public readonly ?string $document_image1,
        public readonly ?string $document_image2,
        public readonly ?string $expiry_date_nepali,
        public readonly ?string $expiry_date_english,
    ) {}

    public static function buildFromValidatedRequest(array $request): CustomerKycDto
    {
        return new self(
            name: $request['name'] ?? null,
            email: $request['email'] ?? null,
            gender: $request['gender'] ?? null,
            grandfather_name: $request['grandfather_name'] ?? null,
            father_name: $request['father_name'] ?? null,
            mother_name: $request['mother_name'] ?? null,
            spouse_name: $request['spouse_name'] ?? null,
            nepali_date_of_birth: $request['nepali_date_of_birth'] ?? null,
            english_date_of_birth: $request['english_date_of_birth'] ?? null,
            permanent_province_id: $request['permanent_province_id'] ?? null,
            permanent_district_id: $request['permanent_district_id'] ?? null,
            permanent_local_body_id: $request['permanent_local_body_id'] ?? null,
            permanent_ward: $request['permanent_ward'] ?? null,
            permanent_tole: $request['permanent_tole'] ?? null,
            temporary_province_id: $request['temporary_province_id'] ?? null,
            temporary_district_id: $request['temporary_district_id'] ?? null,
            temporary_local_body_id: $request['temporary_local_body_id'] ?? null,
            temporary_ward: $request['temporary_ward'] ?? null,
            temporary_tole: $request['temporary_tole'] ?? null,
            document_type: $request['document_type'] ?? null,
            document_issued_date_nepali: $request['document_issued_date_nepali'] ?? null,
            document_issued_date_english: $request['document_issued_date_english'] ?? null,
            document_issued_at: $request['document_issued_at'] ?? null,
            document_number: $request['document_number'] ?? null,
            document_image1: $request['document_image1'] ?? null,
            document_image2: $request['document_image2'] ?? null,
            expiry_date_nepali: $request['expiry_date_nepali'] ?? null,
            expiry_date_english: $request['expiry_date_english'] ?? null,
        );
    }
}
