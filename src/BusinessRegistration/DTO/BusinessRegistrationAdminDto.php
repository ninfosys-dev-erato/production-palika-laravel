<?php

namespace Src\BusinessRegistration\DTO;

use App\Traits\HelperDate;
use Illuminate\Support\Facades\Auth;
use Src\BusinessRegistration\Enums\BusinessRegistrationType;
use Src\BusinessRegistration\Models\BusinessRegistration;

class BusinessRegistrationAdminDto
{
    use HelperDate;

    public function __construct(
        public string  $registration_type_id,
        public string  $entity_name,
        public ?string $amount,
        public ?string $bill_no,
        public ?string $applicant_number,
        public ?string $applicant_name,
        public ?string $application_date,
        public ?string $application_date_en,
        public ?string $registration_date,
        public ?string $registration_date_en,
        public ?string $registration_number,
        public ?string $certificate_number,
        public ?int $department_id,
        public ?int $business_nature,
        public string  $province_id,
        public string  $district_id,
        public string  $local_body_id,
        public string  $ward_no,
        public ?string $way,
        public ?string $tole,
        public array   $data,
        public string  $mobile_no,
        public ?int    $created_by,
        public ?int    $updated_by,
        public ?int    $operator_id,
        public ?int    $preparer_id,
        public ?int    $approver_id,
        public BusinessRegistrationType $registrationType,
        public $registration_id,
    ) {}

    public static function fromLiveWireModel(BusinessRegistration $businessRegistration, bool $admin = false): BusinessRegistrationAdminDto
    {
        return new self(
            registration_type_id: $businessRegistration->registration_type_id,
            entity_name: $businessRegistration->entity_name,
            amount: $businessRegistration->amount ?? null,
            applicant_number: $businessRegistration->applicant_number ?? null,
            applicant_name: $businessRegistration->applicant_name ?? null,
            bill_no: $businessRegistration->bill_no ?? null,
            application_date: $businessRegistration->application_date ?? null,
            application_date_en: $businessRegistration->application_date_en ?? null,
            registration_date: $businessRegistration->registration_date ?? null,
            registration_date_en: $businessRegistration->registration_date_en ?? null,
            registration_number: $businessRegistration->registration_number ?? null,
            certificate_number: $businessRegistration->certificate_number ?? null,
            department_id: $businessRegistration->department_id ?? null,
            business_nature: $businessRegistration->business_nature ?? null,
            province_id: $businessRegistration->province_id,
            district_id: $businessRegistration->district_id,
            local_body_id: $businessRegistration->local_body_id,
            ward_no: $businessRegistration->ward_no,
            way: $businessRegistration->way ?? null,
            tole: $businessRegistration->tole ?? null,
            data: $businessRegistration->data ?? [],
            mobile_no: $businessRegistration->mobile_no ?? null,
            created_by: $admin ? Auth::user()->id : Auth::guard('customer')->id(),
            updated_by: $admin ? Auth::user()->id : Auth::guard('customer')->id(),
            operator_id: $businessRegistration->operator_id ?? null,
            preparer_id: $businessRegistration->preparer_id ?? null,
            approver_id: $businessRegistration->approver_id ?? null,
            registrationType: BusinessRegistrationType::REGISTRATION,
            registration_id: null,
        );
    }
    public static function fromDeRegistrationLiveWireModel(BusinessRegistration $businessRegistration, bool $admin = false): BusinessRegistrationAdminDto
    {
        return new self(
            registration_type_id: $businessRegistration->registration_type_id,
            entity_name: $businessRegistration->entity_name,
            amount: $businessRegistration->amount ?? null,
            applicant_number: $businessRegistration->applicant_number ?? null,
            applicant_name: $businessRegistration->applicant_name ?? null,
            bill_no: $businessRegistration->bill_no ?? null,
            application_date: $businessRegistration->application_date ?? null,
            application_date_en: $businessRegistration->application_date_en ?? null,
            registration_date: $businessRegistration->registration_date ?? null,
            registration_date_en: $businessRegistration->registration_date_en ?? null,
            registration_number: $businessRegistration->registration_number ?? null,
            certificate_number: $businessRegistration->certificate_number ?? null,
            department_id: $businessRegistration->department_id ?? null,
            business_nature: $businessRegistration->business_nature ?? null,
            province_id: $businessRegistration->province_id,
            district_id: $businessRegistration->district_id,
            local_body_id: $businessRegistration->local_body_id,
            ward_no: $businessRegistration->ward_no,
            way: $businessRegistration->way ?? null,
            tole: $businessRegistration->tole ?? null,
            data: $businessRegistration->data ?? [],
            mobile_no: $businessRegistration->mobile_no ?? null,
            created_by: $admin ? Auth::user()->id : Auth::guard('customer')->id(),
            updated_by: $admin ? Auth::user()->id : Auth::guard('customer')->id(),
            operator_id: $businessRegistration->operator_id ?? null,
            preparer_id: $businessRegistration->preparer_id ?? null,
            approver_id: $businessRegistration->approver_id ?? null,
            registrationType: BusinessRegistrationType::DEREGISTRATION,
            registration_id: $businessRegistration->id,
        );
    }
}
