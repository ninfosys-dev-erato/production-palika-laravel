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
        public int $registration_type_id,
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
        public $registration_id,
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
            registration_id: null,
            registration_category: $businessRegistration->registration_category ?? null,
        );
    }

    public static function fromDeRegistrationLiveWireModel(BusinessRegistration $businessRegistration, bool $admin = false): BusinessRegistrationAdminDto
    {
        return new self(
            registration_type_id: $businessRegistration->registration_type_id,
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

            amount: $businessRegistration->amount ?? null,
            bill_no: $businessRegistration->bill_no ?? null,
            application_rejection_reason: $businessRegistration->application_rejection_reason ?? null,

            application_date: $businessRegistration->application_date ?? null,
            application_date_en: $businessRegistration->application_date_en ?? null,

            registration_date_en: $businessRegistration->registration_date_en ?? null,
            registration_date: $businessRegistration->registration_date,

            registration_number: $businessRegistration->registration_number ?? null,
            certificate_number: $businessRegistration->certificate_number ?? null,
            created_by: $admin ? Auth::user()?->id : Auth::guard('customer')->id(),
            updated_by: $admin ? Auth::user()?->id : Auth::guard('customer')->id(),
            data: $businessRegistration->data ?? [],

            registrationType: BusinessRegistrationType::DEREGISTRATION,
            registration_id: $businessRegistration->id,
            registration_category: $businessRegistration->registration_category ?? null,
        );
    }

    // public static function fromArray(array $data): self
    // {
    //     return new self(
    //         entity_name: $data['entity_name'],
    //         fiscal_year: $data['fiscal_year'],
    //         registration_date: $data['registration_date'],

    //         business_nature: $data['business_nature'] ?? null,
    //         main_service_or_goods: $data['main_service_or_goods'] ?? null,
    //         total_capital: $data['total_capital'] ?? null,
    //         business_province: $data['business_province'] ?? null,
    //         business_district: $data['business_district'] ?? null,
    //         business_local_body: $data['business_local_body'] ?? null,
    //         business_ward: $data['business_ward'] ?? null,
    //         business_tole: $data['business_tole'] ?? null,
    //         business_street: $data['business_street'] ?? null,

    //         working_capital: $data['working_capital'] ?? null,
    //         fixed_capital: $data['fixed_capital'] ?? null,
    //         capital_investment: $data['capital_investment'] ?? null,
    //         financial_source: $data['financial_source'] ?? null,
    //         required_electric_power: $data['required_electric_power'] ?? null,
    //         production_capacity: $data['production_capacity'] ?? null,
    //         required_manpower: $data['required_manpower'] ?? null,
    //         number_of_shifts: $data['number_of_shifts'] ?? null,
    //         operation_date: $data['operation_date'] ?? null,
    //         others: $data['others'] ?? null,
    //         houseownername: $data['houseownername'] ?? null,
    //         phone: $data['phone'] ?? null,
    //         monthly_rent: $data['monthly_rent'] ?? null,
    //         rentagreement: $data['rentagreement'] ?? null,
    //         east: $data['east'] ?? null,
    //         west: $data['west'] ?? null,
    //         north: $data['north'] ?? null,
    //         south: $data['south'] ?? null,
    //         landplotnumber: $data['landplotnumber'] ?? null,
    //         area: $data['area'] ?? null,
    //         is_rented: $data['is_rented'] ?? null,

    //         registration_type_id: $data['registration_type_id'],
    //         registrationType: BusinessRegistrationType::REGISTRATION,

    //         amount: $data['amount'] ?? null,
    //         application_rejection_reason: $data['application_rejection_reason'] ?? null,
    //         bill_no: $data['bill_no'] ?? null,

    //         application_date: $data['application_date'],
    //         application_date_en: $data['application_date_en'] ?? null,
    //         registration_date_en: $data['registration_date_en'] ?? null,

    //         registration_number: $data['registration_number'] ?? null,
    //         certificate_number: $data['certificate_number'] ?? null,
    //         created_by: $data['created_by'] ?? null,
    //         updated_by: $data['updated_by'] ?? null,
    //         data: $data['data'] ?? [],
    //         registration_id: $data['registration_id'] ?? null,
    //     );
    // }

    // public function toArray(): array
    // {
    //     return [
    //         'entity_name' => $this->entity_name,
    //         'fiscal_year' => $this->fiscal_year,
    //         'registration_date' => $this->registration_date,

    //         'business_nature' => $this->business_nature,
    //         'main_service_or_goods' => $this->main_service_or_goods,
    //         'total_capital' => $this->total_capital,
    //         'business_province' => $this->business_province,
    //         'business_district' => $this->business_district,
    //         'business_local_body' => $this->business_local_body,
    //         'business_ward' => $this->business_ward,
    //         'business_tole' => $this->business_tole,
    //         'business_street' => $this->business_street,

    //         'working_capital' => $this->working_capital,
    //         'fixed_capital' => $this->fixed_capital,
    //         'capital_investment' => $this->capital_investment,
    //         'financial_source' => $this->financial_source,
    //         'required_electric_power' => $this->required_electric_power,
    //         'production_capacity' => $this->production_capacity,
    //         'required_manpower' => $this->required_manpower,
    //         'number_of_shifts' => $this->number_of_shifts,
    //         'operation_date' => $this->operation_date,
    //         'others' => $this->others,
    //         'houseownername' => $this->houseownername,
    //         'phone' => $this->phone,
    //         'monthly_rent' => $this->monthly_rent,
    //         'rentagreement' => $this->rentagreement,
    //         'east' => $this->east,
    //         'west' => $this->west,
    //         'north' => $this->north,
    //         'south' => $this->south,
    //         'landplotnumber' => $this->landplotnumber,
    //         'area' => $this->area,
    //         'is_rented' => $this->is_rented,

    //         'registration_type_id' => $this->registration_type_id,
    //         'registrationType' => $this->registrationType,

    //         'amount' => $this->amount,
    //         'application_rejection_reason' => $this->application_rejection_reason,
    //         'bill_no' => $this->bill_no,

    //         'application_date' => $this->application_date,
    //         'application_date_en' => $this->application_date_en,
    //         'registration_date_en' => $this->registration_date_en,
    //         'registration_date' => $this->registration_date,

    //         'registration_number' => $this->registration_number,
    //         'certificate_number' => $this->certificate_number,
    //         'created_by' => $this->created_by,
    //         'updated_by' => $this->updated_by,
    //         'data' => $this->data,
    //         'registration_id' => $this->registration_id,
    //     ];
    // }
}
