<?php

namespace Src\BusinessRegistration\DTO;

use App\Traits\HelperDate;
use Illuminate\Support\Facades\Auth;
use Src\BusinessRegistration\Enums\BusinessRegistrationType;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Src\Customers\Enums\GenderEnum;

class BusinessRegistrationAdminDto
{
    use HelperDate;

    public function __construct(
        public string $entity_name,
        public string $fiscal_year,
        public ?string $registration_date,

        // Business Location
        public ?string $business_nature,
        public ?string $main_service_or_goods,
        public ?string $total_capital,
        public ?string $business_province,
        public ?string $business_district,
        public ?string $business_local_body,
        public ?string $business_ward,
        public ?string $business_tole,
        public ?string $business_street,

        // New fields
        public ?string $working_capital,
        public ?string $fixed_capital,
        public ?string $capital_investment,
        public ?string $financial_source,
        public ?string $required_electric_power,
        public ?string $production_capacity,
        public ?string $required_manpower,
        public ?string $number_of_shifts,
        public ?string $operation_date,
        public ?string $others,
        public ?string $houseownername,
        public ?string $phone,
        public ?string $monthly_rent,
        public ?string $rentagreement,
        public ?string $east,
        public ?string $west,
        public ?string $north,
        public ?string $south,
        public ?string $landplotnumber,
        public ?string $area,
        public ?bool $is_rented,

        //business type
        public int $registration_type_id, //this is the id of the registration type
        public BusinessRegistrationType $registrationType,

        //remaining fields
        public ?string $amount,
        public ?string $bill_no,
        public string $application_date,
        public ?string $application_date_en,
        public ?string $registration_date_en,
        public ?string $registration_number,
        public ?string $certificate_number,
        public ?string $total_running_day,
        public ?string $application_rejection_reason,
        public ?int $created_by,
        public ?int $updated_by,
        public array $data,
        public ?string $registration_category = null,
    ) {}

    public static function fromLiveWireModel(BusinessRegistration $businessRegistration, bool $admin = false): self
    {
        return new self(
            entity_name: $businessRegistration->entity_name,
            fiscal_year: $businessRegistration->fiscal_year,

            business_nature: $businessRegistration->business_nature ?? null,
            main_service_or_goods: $businessRegistration->main_service_or_goods ?? null,
            total_capital: $businessRegistration->total_capital ?? null,
            business_province: $businessRegistration->business_province ?? null,
            business_district: $businessRegistration->business_district ?? null,
            business_local_body: $businessRegistration->business_local_body ?? null,
            business_ward: $businessRegistration->business_ward ?? null,
            business_tole: $businessRegistration->business_tole ?? null,
            business_street: $businessRegistration->business_street ?? null,

            working_capital: $businessRegistration->working_capital ?? null,
            fixed_capital: $businessRegistration->fixed_capital ?? null,
            capital_investment: $businessRegistration->capital_investment ?? null,
            financial_source: $businessRegistration->financial_source ?? null,
            required_electric_power: $businessRegistration->required_electric_power ?? null,
            production_capacity: $businessRegistration->production_capacity ?? null,
            required_manpower: $businessRegistration->required_manpower ?? null,
            number_of_shifts: $businessRegistration->number_of_shifts ?? null,
            operation_date: $businessRegistration->operation_date ?? null,
            others: $businessRegistration->others ?? null,
            houseownername: $businessRegistration->houseownername ?? null,
            phone: $businessRegistration->phone ?? null,
            monthly_rent: $businessRegistration->monthly_rent ?? null,
            rentagreement: $businessRegistration->rentagreement ?? null,
            east: $businessRegistration->east ?? null,
            west: $businessRegistration->west ?? null,
            north: $businessRegistration->north ?? null,
            south: $businessRegistration->south ?? null,
            landplotnumber: $businessRegistration->landplotnumber ?? null,
            area: $businessRegistration->area ?? null,
            is_rented: $businessRegistration->is_rented,
            total_running_day: $businessRegistration->total_running_day,

            registration_type_id: $businessRegistration->registration_type_id,
            registrationType: BusinessRegistrationType::REGISTRATION,

            amount: $businessRegistration->amount ?? null,
            application_rejection_reason: $businessRegistration->application_rejection_reason ?? null,
            bill_no: $businessRegistration->bill_no ?? null,

            application_date: $businessRegistration->application_date ?? null,
            application_date_en: $businessRegistration->application_date_en ?? null,
            registration_date_en: $businessRegistration->application_date_en ?? null,
            registration_date: $businessRegistration->registration_date,

            registration_number: $businessRegistration->registration_number ?? null,
            certificate_number: $businessRegistration->certificate_number ?? null,
            created_by: $admin ? Auth::user()?->id : Auth::guard('customer')->id(),
            updated_by: $admin ? Auth::user()?->id : Auth::guard('customer')->id(),
            data: $businessRegistration->data ?? [],
            registration_category: $businessRegistration->registration_category ?? null,
        );
    }
}
