<?php

namespace Src\BusinessRegistration\Service;

use Illuminate\Support\Facades\Auth;
use Src\BusinessRegistration\DTO\BusinessRegistrationApplicantDto;
use Src\BusinessRegistration\Models\BusinessRegistrationApplicant;

class BusinessRegistrationApplicantService
{

    public function store(BusinessRegistrationApplicantDto $dto): BusinessRegistrationApplicant
    {
        $businessRegistrationApplicant = BusinessRegistrationApplicant::create([
            'business_registration_id'      => $dto->business_registration_id,
            'applicant_name'               => $dto->applicant_name,
            'gender'                       => $dto->gender,
            'father_name'                  => $dto->father_name,
            'grandfather_name'             => $dto->grandfather_name,
            'phone'                        => $dto->phone,
            'email'                        => $dto->email,
            'citizenship_number'           => $dto->citizenship_number,
            'citizenship_issued_date'      => $dto->citizenship_issued_date,
            'citizenship_issued_district'  => $dto->citizenship_issued_district,
            'applicant_province'           => $dto->applicant_province,
            'applicant_district'           => $dto->applicant_district,
            'applicant_local_body'         => $dto->applicant_local_body,
            'applicant_ward'               => $dto->applicant_ward,
            'applicant_tole'               => $dto->applicant_tole,
            'applicant_street'             => $dto->applicant_street,
            'position'                     => $dto->position,
            'citizenship_front'            => $dto->citizenship_front,
            'citizenship_rear'             => $dto->citizenship_rear,
        ]);

        return $businessRegistrationApplicant;
    }

    public function update(BusinessRegistrationApplicant $businessRegistrationApplicant, BusinessRegistrationApplicantDto $dto): BusinessRegistrationApplicant
    {
        $businessRegistrationApplicant->update([
            'applicant_name'               => $dto->applicant_name,
            'gender'                       => $dto->gender,
            'father_name'                  => $dto->father_name,
            'grandfather_name'             => $dto->grandfather_name,
            'phone'                        => $dto->phone,
            'email'                        => $dto->email,
            'citizenship_number'           => $dto->citizenship_number,
            'citizenship_issued_date'      => $dto->citizenship_issued_date,
            'citizenship_issued_district'  => $dto->citizenship_issued_district,
            'applicant_province'           => $dto->applicant_province,
            'applicant_district'           => $dto->applicant_district,
            'applicant_local_body'         => $dto->applicant_local_body,
            'applicant_ward'               => $dto->applicant_ward,
            'applicant_tole'               => $dto->applicant_tole,
            'applicant_street'             => $dto->applicant_street,
            'position'                     => $dto->position,
            'citizenship_front'            => $dto->citizenship_front,
            'citizenship_rear'             => $dto->citizenship_rear,
        ]);

        return $businessRegistrationApplicant;
    }
}
