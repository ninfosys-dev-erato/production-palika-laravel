<?php

namespace Src\BusinessRegistration\DTO;



class BusinessRegistrationApplicantDto
{
    public function __construct(
        public string $applicant_name,
        public ?string $gender = null,
        public ?string $father_name = null,
        public ?string $grandfather_name = null,
        public ?string $phone = null,
        public ?string $email = null,
        public ?string $citizenship_number = null,
        public ?string $citizenship_issued_date = null,
        public ?string $citizenship_issued_district = null,
        public ?string $applicant_province = null,
        public ?string $applicant_district = null,
        public ?string $applicant_local_body = null,
        public ?string $applicant_ward = null,
        public ?string $applicant_tole = null,
        public ?string $applicant_street = null,
        public ?string $position = null,
        public ?string $citizenship_front = null,
        public ?string $citizenship_rear = null,
        public ?string $business_registration_id,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            applicant_name: $data['applicant_name'],
            gender: $data['gender'] ?? null,
            father_name: $data['father_name'] ?? null,
            grandfather_name: $data['grandfather_name'] ?? null,
            phone: $data['phone'] ?? null,
            email: $data['email'] ?? null,
            citizenship_number: $data['citizenship_number'] ?? null,
            citizenship_issued_date: $data['citizenship_issued_date'] ?? null,
            citizenship_issued_district: $data['citizenship_issued_district'] ?? null,
            applicant_province: $data['applicant_province'] ?? null,
            applicant_district: $data['applicant_district'] ?? null,
            applicant_local_body: $data['applicant_local_body'] ?? null,
            applicant_ward: $data['applicant_ward'] ?? null,
            applicant_tole: $data['applicant_tole'] ?? null,
            applicant_street: $data['applicant_street'] ?? null,
            position: $data['position'] ?? null,
            citizenship_front: $data['citizenship_front'] ?? null,
            citizenship_rear: $data['citizenship_rear'] ?? null,
            business_registration_id: $data['business_registration_id'] ?? null
        );
    }
}
