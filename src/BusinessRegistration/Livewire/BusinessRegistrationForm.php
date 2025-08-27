<?php

namespace Src\BusinessRegistration\Livewire;

use App\Enums\Action;
use App\Facades\FileFacade;
use App\Facades\ImageServiceFacade;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use PDO;
use Src\Address\Models\Province;
use Src\BusinessRegistration\DTO\BusinessRegistrationAdminDto;
use Src\BusinessRegistration\DTO\BusinessRegistrationApplicantDto;
use Src\BusinessRegistration\Enums\BusinessRegistrationType;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Src\BusinessRegistration\Models\NatureOfBusiness;
use Src\BusinessRegistration\Models\RegistrationCategory;
use Src\BusinessRegistration\Models\RegistrationType;
use Src\BusinessRegistration\Service\BusinessRegistrationAdminService;
use Src\BusinessRegistration\Service\BusinessRegistrationApplicantService;
use Src\BusinessRegistration\Service\BusinessRequiredDocService;
use Src\Customers\Enums\GenderEnum;
use Src\Employees\Models\Branch;
use Illuminate\Support\Facades\DB;
use Src\Address\Models\District;
use Src\BusinessRegistration\Enums\RegistrationCategoryEnum;
use Src\Settings\Models\FiscalYear;
use Livewire\Attributes\On;
use Src\Customers\Models\Customer;

class BusinessRegistrationForm extends Component
{
    use SessionFlash, WithFileUploads, HelperDate;

    public ?BusinessRegistration $businessRegistration;
    public ?Action $action;
    public ?RegistrationType $registrationType;

    public  $businessRegistrationType;

    public $registrationTypes = [];
    public $data = [];
    public $provinces = [];
    public $districts = [];
    public $localBodies = [];
    public $wards = [];

    public $applicantDistricts = [];
    public $applicantLocalBodies = [];
    public $applicantWards = [];


    public $businessDistricts = [];
    public $businessLocalBodies = [];
    public $businessWards = [];
    public $fiscalYears = [];
    public $activeTab = 'personal';


    public $citizenShipFrontPhotoUrl;
    public $citizenshipFrontPhoto;
    public $citizenShipRearPhotoUrl;
    public $citizenshipRearPhoto;

    public $showRegistrationDetailsFields = false;
    public $is_previouslyRegistered = 0;
    public $selectedFiscalYearText = '';


    public array $personalDetails = [
        [
            'applicant_name' => '',
            'gender' => '',
            'father_name' => '',
            'grandfather_name' => '',
            'phone' => '',
            'email' => '',
            'citizenship_number' => '',
            'citizenship_issued_date' => '',
            'citizenship_issued_district' => '',
            'applicant_province' => '',
            'applicant_district' => '',
            'applicant_local_body' => '',
            'applicant_ward' => '',
            'applicant_tole' => '',
            'applicant_street' => '',
            'position' => '',
            'citizenship_front' => null,
            'citizenship_rear' => null,
            'citizenship_front_url' => null,
            'citizenship_rear_url' => null,
        ]
    ];

    public $registrationCategories = [];
    public ?bool $showCategory = true;
    public bool $hasDepartment = false;
    public  $departmentUser = [];
    public  $businessNatures = [];
    public  $departments = [];
    public $search;
    public $showData = false;
    public $registrationCategory;
    public $registration = null;
    protected $listeners = ['setActiveTab'];

    public $genders;

    public $citizenshipDistricts;
    public $registrationTypeEnum;
    public $showRentFields = false;

    public array $requiredBusinessDocuments = [];

    public array $businessRequiredDoc = []; // Holds uploaded file names
    public array $businessRequiredDocUrl = []; // Holds temporary preview URLs

    public $rentagreement; // Holds uploaded file name
    public $rentagreement_url;
    public $isCustomer = false;




    public function rules(): array
    {
        $rules = [
            // Personal Detail - now handled in separate table
            'personalDetails.*.applicant_name' => ['required'],
            'personalDetails.*.gender' => ['nullable'],
            'personalDetails.*.father_name' => ['nullable'],
            'personalDetails.*.grandfather_name' => ['nullable'],
            'personalDetails.*.phone' => ['nullable'],
            'personalDetails.*.email' => ['nullable'],
            'personalDetails.*.citizenship_number' => ['nullable'],
            'personalDetails.*.citizenship_issued_date' => ['nullable'],
            'personalDetails.*.citizenship_issued_district' => ['nullable'],
            'personalDetails.*.applicant_province' => ['nullable'],
            'personalDetails.*.applicant_district' => ['nullable'],
            'personalDetails.*.applicant_local_body' => ['nullable'],
            'personalDetails.*.applicant_ward' => ['nullable'],
            'personalDetails.*.applicant_tole' => ['nullable'],
            'personalDetails.*.applicant_street' => ['nullable'],
            'personalDetails.*.position' => ['nullable'],
            'personalDetails.*.citizenship_front' => ['nullable'],
            'personalDetails.*.citizenship_rear' => ['nullable'],
            // Business Detail
            'businessRegistration.fiscal_year' => ['required'],
            'businessRegistration.application_date' => ['required'],
            'businessRegistration.entity_name' => ['required'],

            'businessRegistration.business_nature' => ['nullable'],
            'businessRegistration.business_category' => ['nullable'],
            'businessRegistration.kardata_number' => ['nullable'],
            'businessRegistration.kardata_miti' => ['nullable'],
            'businessRegistration.main_service_or_goods' => ['nullable'],
            'businessRegistration.total_capital' => ['nullable'],
            'businessRegistration.business_province' => ['nullable'],
            'businessRegistration.business_district' => ['nullable'],
            'businessRegistration.business_local_body' => ['nullable'],
            'businessRegistration.business_ward' => ['nullable'],
            'businessRegistration.business_tole' => ['nullable'],
            'businessRegistration.business_street' => ['nullable'],
            'businessRegistration.is_rented' => ['nullable'],
            'businessRegistration.purpose' => ['nullable'],
            'businessRegistration.registration_category' => ['nullable'],

            'businessRegistration.registration_date' => $this->is_previouslyRegistered ? ['required'] : ['nullable'],
            // 'businessRegistration.registration_number' => $this->is_previouslyRegistered ? ['required'] : ['nullable'],

            'businessRegistration.registration_number' => [
                $this->is_previouslyRegistered ? 'required' : 'nullable',
                'numeric',
                function ($attribute, $value, $fail) {
                    if ($this->is_previouslyRegistered && $value) {
                        $serial = (int) $value;
                        $padded = str_pad($serial, 6, '0', STR_PAD_LEFT);
                        $fiscalYear = $this->selectedFiscalYearText;
                        $fullNumber = $padded . '/' . replaceNumbers($fiscalYear);

                        $exists = BusinessRegistration::where('registration_number', $fullNumber)
                            ->when($this->businessRegistration?->id, function ($query) {
                                $query->where('id', '!=', $this->businessRegistration->id);
                            })
                            ->whereNull('deleted_at')
                            ->exists();

                        if ($exists) {
                            $fail(__('businessregistration::businessregistration.registration_number_already_exists'));
                        }
                    }
                },
            ],


            // New fields for business registration
            'businessRegistration.working_capital' => ['nullable'],
            'businessRegistration.fixed_capital' => ['nullable'],
            'businessRegistration.capital_investment' => ['nullable'],
            'businessRegistration.financial_source' => ['nullable'],
            'businessRegistration.required_electric_power' => ['nullable'],
            'businessRegistration.production_capacity' => ['nullable'],
            'businessRegistration.required_manpower' => ['nullable'],
            'businessRegistration.number_of_shifts' => ['nullable'],
            'businessRegistration.operation_date' => ['nullable'],
            'businessRegistration.others' => ['nullable'],
            'businessRegistration.houseownername' => ['nullable'],
            'businessRegistration.house_owner_phone' => ['nullable'],
            'businessRegistration.monthly_rent' => ['nullable'],
            'businessRegistration.rentagreement' => ['nullable'],
            'businessRegistration.east' => ['nullable'],
            'businessRegistration.west' => ['nullable'],
            'businessRegistration.north' => ['nullable'],
            'businessRegistration.south' => ['nullable'],
            'businessRegistration.landplotnumber' => ['nullable'],
            'businessRegistration.area' => ['nullable'],
            'businessRegistration.total_running_day' => ['nullable'],

            // Registration Type
            'businessRegistration.registration_type_id' => ['required'],

            // Business Required Documents validation
            'businessRequiredDoc.*' => ['nullable'], // 10MB max
        ];

        // Conditional rules if department exists
        if ($this->hasDepartment) {
            $rules['businessRegistration.operator_id'] = ['nullable', Rule::exists('users', 'id')];
            $rules['businessRegistration.preparer_id'] = ['nullable', Rule::exists('users', 'id')];
            $rules['businessRegistration.approver_id'] = ['nullable', Rule::exists('users', 'id')];
        }

        return $rules;
    }



    public function messages(): array
    {
        return [
            // Personal Details
            'personalDetails.*.applicant_name.required' => __('businessregistration::businessregistration.the_applicant_name_is_required'),

            // Business Details
            'businessRegistration.fiscal_year.required' => __('businessregistration::businessregistration.the_fiscal_year_is_required'),
            'businessRegistration.application_date.required' => __('businessregistration::businessregistration.application_date_is_required'),
            'businessRegistration.entity_name.required' => __('businessregistration::businessregistration.the_entity_name_is_required'),

            // Registration Type
            'businessRegistration.registration_type_id.required' => __('businessregistration::businessregistration.the_registration_type_is_required'),
            'businessRegistration.registration_type_id.exists' => __('businessregistration::businessregistration.the_registration_type_must_be_valid'),

            //Registration Date and Number
            'businessRegistration.registration_date.required' => __('businessregistration::businessregistration.the_registration_date_is_required'),
            'businessRegistration.registration_number.required' => __('businessregistration::businessregistration.the_registration_number_is_required'),
        ];
    }



    public function render(): View
    {
        return view('BusinessRegistration::livewire.business-registration.form');
    }

    public function mount(?BusinessRegistration $businessRegistration, Action $action, ?BusinessRegistrationType $businessRegistrationType, $registration = null)
    {

        $this->businessRegistration = $businessRegistration;
        $this->businessRegistrationType = $businessRegistrationType;


        $this->action = $action;
        $this->fiscalYears = FiscalYear::whereNull('deleted_at')->pluck('year', 'id')->toArray();
        $this->provinces = Province::whereNull('deleted_at')->pluck('title', 'id')->toArray();

        $action = match ($businessRegistrationType) {
            BusinessRegistrationType::ARCHIVING => BusinessRegistrationType::REGISTRATION->value,
            default => $businessRegistrationType->value,
        };

        $this->registrationTypes = RegistrationType::whereNull('deleted_at')
            ->where('action', $action)
            ->where('status', true)
            ->pluck('title', 'id');

        if (Auth::guard('customer')->user()) {
            $this->isCustomer = true;
        }

        $this->registrationCategories = RegistrationCategory::pluck('title', 'id')->toArray();

        $this->businessNatures = NatureOfBusiness::whereNull('deleted_at')->whereNull('deleted_by')->pluck('title', 'id')->toArray();
        $this->activeTab = 'personal';

        $this->genders = GenderEnum::getValuesWithLabels();
        $this->citizenshipDistricts = District::whereNull('deleted_at')->pluck('title', 'id');


        $this->departments = Branch::whereNull('deleted_at')->whereNull('deleted_by')->pluck('id', 'title')->toArray();

        if ($this->action == Action::CREATE) {
            $this->preSetBusinessAddress();

            if ($this->isCustomer) {

                $customer = Auth::guard('customer')->user();
                if ($customer) {
                    // Create the result array that restructureData expects
                    $result = [
                        'type' => 'Customer',
                        'id' => $customer->id
                    ];
                    $this->restructureData($result);
                }
            }
        }
        if ($this->action == Action::UPDATE && $businessRegistration) {

            $this->loadBusinessRegistrationData($this->businessRegistration);
        }

        if ($registration && $registration->id) {
            $this->registrationType = $registration;
            $this->businessRegistration['category_id'] = $registration->registration_category_id;
            $this->businessRegistration['registration_type_id'] = $registration->id;
            $this->showCategory = false;
            $this->setFields($registration->id);
        }

        if ($this->businessRegistration && !empty($this->businessRegistration['registration_type_id'])) {
            $this->setFields($this->businessRegistration['registration_type_id']);
        }
    }

    protected function loadBusinessRegistrationData($businessRegistration)
    {
        $businessRegistration->loadMissing(['applicants', 'requiredBusinessDocs']);

        if ($businessRegistration['registration_category'] == RegistrationCategoryEnum::BUSINESS->value) {
            $this->showRentFields = true;
        }

        if (!empty($businessRegistration['registration_number'])) {
            $this->showRegistrationDetailsFields = true;
            [$numberPart, $fiscalPart] = explode('/', $businessRegistration['registration_number'], 2);
            $this->businessRegistration['registration_number'] = ltrim($numberPart, '0');
            $this->selectedFiscalYearText = $fiscalPart;
        }

        if (!empty($businessRegistration->rentagreement)) {
            $this->businessRegistration['rentagreement'] = $businessRegistration->rentagreement;
            $this->handleFileUpload(
                file: $businessRegistration->rentagreement,
                field: 'rentagreement',
                target: 'businessRegistration'
            );
        }

        $this->personalDetails = $businessRegistration->applicants
            ->map(function ($applicant) {
                $citizenshipFront = $applicant->citizenship_front;
                $citizenshipRear = $applicant->citizenship_rear;
                return [
                    'applicant_name' => $applicant->applicant_name,
                    'gender' => $applicant->gender,
                    'father_name' => $applicant->father_name,
                    'grandfather_name' => $applicant->grandfather_name,
                    'phone' => $applicant->phone,
                    'email' => $applicant->email,
                    'citizenship_number' => $applicant->citizenship_number,
                    'citizenship_issued_date' => $applicant->citizenship_issued_date,
                    'citizenship_issued_district' => $applicant->citizenship_issued_district,
                    'applicant_province' => $applicant->applicant_province,
                    'applicant_district' => $applicant->applicant_district,
                    'applicant_local_body' => $applicant->applicant_local_body,
                    'applicant_ward' => $applicant->applicant_ward,
                    'applicant_tole' => $applicant->applicant_tole,
                    'applicant_street' => $applicant->applicant_street,
                    'position' => $applicant->position,
                    'citizenship_front' => $citizenshipFront,
                    'citizenship_rear' => $citizenshipRear,
                    'citizenship_front_url' => $citizenshipFront
                        ? FileFacade::getTemporaryUrl(
                            config('src.BusinessRegistration.businessRegistration.registration'),
                            $citizenshipFront,
                            getStorageDisk('private')
                        ) : '',
                    'citizenship_rear_url' => $citizenshipRear
                        ? FileFacade::getTemporaryUrl(
                            config('src.BusinessRegistration.businessRegistration.registration'),
                            $citizenshipRear,
                            getStorageDisk('private')
                        ) : '',
                ];
            })
            ->toArray();

        foreach (array_keys($this->personalDetails) as $index) {
            $this->getApplicantDistricts($index);
            $this->getApplicantLocalBodies($index);
            $this->getApplicantWards($index);
        }

        $this->getBusinessDistricts();
        $this->getBusinessLocalBodies();
        $this->getBusinessWards();
        $this->data = $businessRegistration->data ?? [];

        foreach ($businessRegistration->requiredBusinessDocs ?? [] as $doc) {
            $this->businessRequiredDoc[$doc->document_field] = $doc->document_filename;
            $this->businessRequiredDocUrl[$doc->document_field . '_url'] = FileFacade::getTemporaryUrl(
                config('src.BusinessRegistration.businessRegistration.registration'),
                $doc->document_filename,
                getStorageDisk('private')
            );
        }
    }


    public function preSetBusinessAddress()
    {

        $defaultProvinceId = key(getSettingWithKey('palika-province'));
        $defaultDistrictId = key(getSettingWithKey('palika-district'));
        $defaultLocalBodyId = key(getSettingWithKey('palika-local-body'));

        $this->businessRegistration['business_province'] = $defaultProvinceId;
        $this->businessRegistration['business_district'] = $defaultDistrictId;
        $this->businessRegistration['business_local_body'] = $defaultLocalBodyId;

        $this->personalDetails[0]['applicant_province'] = $defaultProvinceId;
        $this->personalDetails[0]['applicant_district'] = $defaultDistrictId;
        $this->personalDetails[0]['applicant_local_body'] = $defaultLocalBodyId;


        $this->getBusinessDistricts();
        $this->getBusinessLocalBodies();
        $this->getBusinessWards();

        $this->getApplicantDistricts(0);
        $this->getApplicantLocalBodies(0);
        $this->getApplicantWards(0);
    }



    public function addPersonalDetail()
    {
        $defaultProvinceId = key(getSettingWithKey('palika-province'));
        $defaultDistrictId = key(getSettingWithKey('palika-district'));
        $defaultLocalBodyId = key(getSettingWithKey('palika-local-body'));

        $this->personalDetails[] = [
            'applicant_name' => '',
            'gender' => '',
            'father_name' => '',
            'grandfather_name' => '',
            'phone' => '',
            'email' => '',
            'citizenship_number' => '',
            'citizenship_issued_date' => '',
            'citizenship_issued_district' => '',
            'applicant_province' => $defaultProvinceId,
            'applicant_district' => $defaultDistrictId,
            'applicant_local_body' => $defaultLocalBodyId,
            'applicant_ward' => '',
            'applicant_tole' => '',
            'applicant_street' => '',
            'position' => '',
            'citizenship_front' => null,
            'citizenship_rear' => null,
            'citizenship_front_url' => null,
            'citizenship_rear_url' => null,
        ];

        $index = count($this->personalDetails) - 1;

        // Optionally populate dependent data for the new entry
        $this->getApplicantDistricts($index);
        $this->getApplicantLocalBodies($index);
        $this->getApplicantWards($index);
    }


    public function removePersonalDetail($index)
    {
        unset($this->personalDetails[$index]);
        $this->personalDetails = array_values($this->personalDetails); // reindex
        $this->successToast(__('businessregistration::businessregistration.personal_detail_removed_successfully'));
    }


    public function getApplicantDistricts($index): void
    {
        $province = $this->personalDetails[$index]['applicant_province'] ?? null;
        $this->applicantDistricts[$index] = $province
            ? getDistricts($province)->pluck('title', 'id')->toArray()
            : [];
        $this->applicantLocalBodies[$index] = [];
        $this->applicantWards[$index] = [];
    }

    public function getApplicantLocalBodies($index): void
    {
        $district = $this->personalDetails[$index]['applicant_district'] ?? null;
        $this->applicantLocalBodies[$index] = $district
            ? getLocalBodies($district)->pluck('title', 'id')->toArray()
            : [];
        $this->applicantWards[$index] = [];
    }

    public function getApplicantWards($index): void
    {
        $localBodyId = $this->personalDetails[$index]['applicant_local_body'] ?? null;
        $this->applicantWards[$index] = $localBodyId
            ? getWards(optional(getLocalBodies(localBodyId: $localBodyId))->wards ?? [])
            : [];
    }



    public function getBusinessDistricts(): void
    {
        $province = $this->businessRegistration['business_province'] ?? null;


        $this->businessDistricts = $province
            ? getDistricts($province)->pluck('title', 'id')->toArray()
            : [];

        $this->businessLocalBodies = [];
        $this->businessWards = [];
    }

    public function getBusinessLocalBodies(): void
    {
        $district = $this->businessRegistration['business_district'] ?? null;

        $this->businessLocalBodies = $district
            ? getLocalBodies($district)->pluck('title', 'id')->toArray()
            : [];

        $this->businessWards = [];
    }


    public function getBusinessWards(): void
    {
        $localBodyId = $this->businessRegistration['business_local_body'] ?? null;

        $this->businessWards = $localBodyId
            ? getWards(optional(getLocalBodies(localBodyId: $localBodyId))->wards ?? [])
            : [];
    }


    public function setActiveTab($tab)
    {

        $tabsOrder = ['personal', 'business', 'type'];

        $currentIndex = array_search($this->activeTab, $tabsOrder);
        $targetIndex = array_search($tab, $tabsOrder);

        // Validate only when moving forward not the previous tab
        if ($targetIndex > $currentIndex) {
            if ($this->activeTab === 'personal') {
                $this->validatePersonalTab();
            } elseif ($this->activeTab === 'business') {
                $this->validateBusinessTab();
            } elseif ($this->activeTab === 'type') {
                $this->validateTypeTab();
            }
        }

        // Allow switching tab regardless if moving backward or validation passed
        $this->activeTab = $tab;
    }

    protected function validatePersonalTab()
    {
        $this->validate([
            'personalDetails.*.applicant_name' => ['required'],

        ]);
    }

    protected function validateBusinessTab()
    {
        $this->validate([
            'businessRegistration.fiscal_year' => ['required'],
            'businessRegistration.application_date' => ['required'],
            'businessRegistration.entity_name' => ['required'],
            'businessRegistration.registration_date' => $this->is_previouslyRegistered ? ['required'] : ['nullable'],
            'businessRegistration.registration_number' => $this->is_previouslyRegistered ? ['required'] : ['nullable'],

        ]);
    }

    protected function validateTypeTab()
    {
        $this->validate([
            'businessRegistration.registration_type_id' => ['required'],

        ]);
    }
    public function rentStatusChanged($value)
    {
        $this->businessRegistration['is_rented'] = $value;

        $this->showRentFields = (int) $value === 1;

        // Reset rent fields when "No" is selected
        if ((int) $value === 0) {
            $this->businessRegistration['houseownername'] = '';
            $this->businessRegistration['house_owner_phone'] = '';
            $this->businessRegistration['monthly_rent'] = '';
            $this->rentagreement = null;
            $this->rentagreement_url = '';
        }
    }


    public function previouslyRegisteredChanged($value)
    {
        $this->showRegistrationDetailsFields = (int) $value === 1;

        // Reset registration fields when "No" is selected
        if ((int) $value === 0) {
            $this->businessRegistration['registration_date'] = '';
            $this->businessRegistration['registration_number'] = '';
        }

        // Dispatch event to initialize date pickers when conditional fields are shown
        if ((int) $value === 1) {

            $this->dispatch('init-registration-date');
        }
    }
    public function fiscalYearChanged($value)
    {
        $fiscalYear = FiscalYear::find($value);
        $this->selectedFiscalYearText = $fiscalYear ? $fiscalYear->year : '';
    }




    public function updatedPersonalDetails($value, $name)
    {

        [$index, $field] = explode('.', $name);

        if (in_array($field, ['citizenship_front', 'citizenship_rear'])) {

            $file = $this->personalDetails[$index][$field] ?? null;


            // $this->handleFileUpload($file, (int) $index, $field);
            $this->handleFileUpload($file, $field, (int)$index, 'personal');
        }
    }

    public function updatedBusinessRequiredDoc($value, $field)
    {
        if (isset($this->requiredBusinessDocuments[$field])) {


            $this->handleFileUpload($value, $field, null, 'business');
        }
    }

    public function updatedRentAgreement($value)
    {
        $this->handleFileUpload(
            file: $value,
            field: 'rentagreement',
            target: 'businessRegistration'
        );
    }




    private function handleFileUpload($file, $field, $index = null, $target = 'personal')
    {
        if (!$file) return;

        if (is_string($file)) {

            $filename = $file;
        } else {

            $filename = FileFacade::saveFile(
                path: config('src.BusinessRegistration.businessRegistration.registration'),
                filename: '',
                file: $file,
                disk: getStorageDisk('private'),
            );


        }


        // $filename = FileFacade::saveFile(
        //     path: config('src.BusinessRegistration.businessRegistration.registration'),
        //     file: $file,
        //     disk: 'local',
        //     filename: ''
        // );


        $url = FileFacade::getTemporaryUrl(
            path: config('src.BusinessRegistration.businessRegistration.registration'),
            filename: $filename,
            disk: getStorageDisk('private')
        );

        if ($target === 'personal' && $index !== null) {
            $this->personalDetails[$index][$field] = $filename;
            $this->personalDetails[$index][$field . '_url'] = $url;
        } elseif ($target === 'business') {
            $this->businessRequiredDoc[$field] = $filename;
            $this->businessRequiredDocUrl[$field . '_url'] = $url;
        } elseif ($target === 'businessRegistration') {
            $this->businessRegistration[$field] = $filename;
            $this->{$field . '_url'} = $url;
        }
    }
    #[On('search-user')]
    public function restructureData($result, $personalDetailIndex = 0)
    {
        if ($result['type'] === 'Customer') {
            $customer = Customer::with('kyc')->where('id', $result['id'])->first();

            if ($customer) {
                // Ensure the personal detail index exists
                if (!isset($this->personalDetails[$personalDetailIndex])) {
                    $this->addPersonalDetail();
                }

                // Populate the specific personal detail
                $this->personalDetails[$personalDetailIndex]['applicant_name'] = $customer->name ?? '';
                $this->personalDetails[$personalDetailIndex]['phone'] = $customer->mobile_no ?? '';
                $this->personalDetails[$personalDetailIndex]['email'] = $customer->email ?? '';
                $this->personalDetails[$personalDetailIndex]['gender'] = $customer->gender->value ?? '';

                // Populate KYC data if available
                if ($customer->kyc) {
                    $this->personalDetails[$personalDetailIndex]['father_name'] = $customer->kyc->father_name ?? '';
                    $this->personalDetails[$personalDetailIndex]['grandfather_name'] = $customer->kyc->grandfather_name ?? '';
                    $this->personalDetails[$personalDetailIndex]['citizenship_number'] = $customer->kyc->document_number ?? '';
                    $this->personalDetails[$personalDetailIndex]['citizenship_issued_date'] = $customer->kyc->document_issued_date_nepali ?? '';
                    $this->personalDetails[$personalDetailIndex]['citizenship_issued_district'] = $customer->kyc->document_issued_at ?? '';

                    // Populate address information if available
                    if ($customer->kyc->permanent_province_id) {
                        $this->personalDetails[$personalDetailIndex]['applicant_province'] = $customer->kyc->permanent_province_id;
                        $this->getApplicantDistricts($personalDetailIndex);
                    }
                    if ($customer->kyc->permanent_district_id) {
                        $this->personalDetails[$personalDetailIndex]['applicant_district'] = $customer->kyc->permanent_district_id;
                        $this->getApplicantLocalBodies($personalDetailIndex);
                    }
                    if ($customer->kyc->permanent_local_body_id) {
                        $this->personalDetails[$personalDetailIndex]['applicant_local_body'] = $customer->kyc->permanent_local_body_id;
                        $this->getApplicantWards($personalDetailIndex);
                    }
                    if ($customer->kyc->permanent_ward) {
                        $this->personalDetails[$personalDetailIndex]['applicant_ward'] = $customer->kyc->permanent_ward;
                    }
                    if ($customer->kyc->permanent_tole) {
                        $this->personalDetails[$personalDetailIndex]['applicant_tole'] = $customer->kyc->permanent_tole;
                    }
                }

                // Show success message
                $this->successToast(__('businessregistration::businessregistration.customer_data_loaded_successfully'));
            }
        }
    }
    public function save()
    {
        DB::beginTransaction();
        try {
            $this->validate();
            $this->businessRegistration['data'] = $this->getFormattedData();
            $this->businessRegistration['application_date_en'] = $this->bsToAd($this->businessRegistration['application_date']);

            if (!empty($this->businessRegistration['registration_number'])) {

                $serial = (int) $this->businessRegistration['registration_number'];
                $this->businessRegistration['registration_number'] = $serial
                    . '/' . replaceNumbers($this->selectedFiscalYearText);
            }
            if (!empty($this->businessRegistration['registration_date'])) {
                $this->businessRegistration['registration_date_en'] = $this->bsToAd($this->businessRegistration['registration_date']);
            }

            $service = new BusinessRegistrationAdminService();
            $businessApplicantService = new BusinessRegistrationApplicantService();
            $businessRequiredDocService = new BusinessRequiredDocService();

            switch ($this->action) {
                case Action::CREATE:
                    $this->businessRegistration['registration_type'] = $this->businessRegistrationType->value;
                    $dto = BusinessRegistrationAdminDto::fromLiveWireModel(businessRegistration: $this->businessRegistration, admin: true);


                    $success = $service->store($dto);


                    if ($success instanceof BusinessRegistration) {
                        $businessRegistrationId = $success->id;

                        foreach ($this->personalDetails as $data) {
                            $data['business_registration_id'] = $businessRegistrationId;
                            $dto = BusinessRegistrationApplicantDto::fromArray($data);
                            $businessApplicantService->store($dto);
                        }

                        foreach ($this->businessRequiredDoc as $field => $filename) {
                            if (!empty($filename)) {
                                $documentLabelEn = $this->requiredBusinessDocuments[$field]['en'] ?? $field;
                                $documentLabelNe = $this->requiredBusinessDocuments[$field]['ne'] ?? $field;
                                $dto = new \Src\BusinessRegistration\DTO\BusinessRequiredDocDto(
                                    businessRegistrationId: $businessRegistrationId,
                                    documentField: $field,
                                    documentLabelEn: $documentLabelEn,
                                    documentLabelNe: $documentLabelNe,
                                    documentFilename: $filename
                                );
                                $businessRequiredDocService->store($dto);
                            }
                        }

                        DB::commit();
                        $this->successFlash(__('businessregistration::businessregistration.business_registration_applied_successfully'));

                        // Determine redirect route based on user type
                        if ($this->isCustomer) {
                            return redirect()->route('customer.business-registration.business-registration.index');
                        } else {
                            return redirect()->route('admin.business-registration.business-registration.index', ['type' => $this->businessRegistrationType]);
                        }
                    } else {
                        DB::rollBack();
                        $this->errorFlash(__('businessregistration::businessregistration.business_registration_failed'));
                        return;
                    }

                case Action::UPDATE:
                    $dto = BusinessRegistrationAdminDto::fromLiveWireModel(businessRegistration: $this->businessRegistration, admin: true);

                    $success = $service->update($dto, $this->businessRegistration);

                    if ($success instanceof BusinessRegistration) {
                        $this->businessRegistration->applicants()->delete();
                        foreach ($this->personalDetails as $data) {
                            $data['business_registration_id'] = $this->businessRegistration->id;
                            $dto = BusinessRegistrationApplicantDto::fromArray($data);
                            $businessApplicantService->store($dto);
                        }

                        $this->businessRegistration->requiredBusinessDocs()->delete();
                        foreach ($this->businessRequiredDoc as $field => $filename) {
                            if (!empty($filename)) {
                                $documentLabelEn = $this->requiredBusinessDocuments[$field]['en'] ?? $field;
                                $documentLabelNe = $this->requiredBusinessDocuments[$field]['ne'] ?? $field;
                                $dto = new \Src\BusinessRegistration\DTO\BusinessRequiredDocDto(
                                    businessRegistrationId: $this->businessRegistration->id,
                                    documentField: $field,
                                    documentLabelEn: $documentLabelEn,
                                    documentLabelNe: $documentLabelNe,
                                    documentFilename: $filename
                                );
                                $businessRequiredDocService->store($dto);
                            }
                        }

                        DB::commit();
                        $this->successFlash(__('businessregistration::businessregistration.business_registration_application_updated_successfully'));

                        // Determine redirect route based on user type
                        if ($this->isCustomer) {
                            return redirect()->route('customer.business-registration.business-registration.index');
                        } else {
                            return redirect()->route('admin.business-registration.business-registration.index', ['type' => $this->businessRegistrationType]);
                        }
                    } else {
                        DB::rollBack();
                        $this->errorFlash(__('businessregistration::businessregistration.business_registration_failed'));
                        return;
                    }

                default:
                    DB::rollBack();
                    $this->errorFlash(__('Invalid action.'));

                    // Determine redirect route based on user type
                    if ($this->isCustomer) {
                        return redirect()->route('customer.business-registration.business-registration.index');
                    } else {
                        return redirect()->route('admin.business-registration.business-registration.index', ['type' => $this->businessRegistrationType]);
                    }
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            logger($e->getMessage());
            $this->errorFlash('Something went wrong while saving. ' . $e->getMessage());
        }
    }

    private function mergeExistingDataWithFields($fieldDefinitions, $existingData)
    {
        return collect($fieldDefinitions)->map(function ($field) use ($existingData) {
            if ($field['type'] === "table") {
                $field['fields'] = [];
                $row = [];
                foreach ($field as $key => $values) {
                    if (is_numeric($key)) {
                        $values['value'] = $this->initializeFieldValue($values);
                        $row[$values['slug']] = $values;
                        unset($field[$key]);
                    }
                }
                $field['fields'][] = $row;

                // If editing and we have existing table data, merge it
                if ($this->action === Action::UPDATE && isset($existingData[$field['slug']])) {
                    $existingField = $existingData[$field['slug']];
                    if (isset($existingField['fields']) && is_array($existingField['fields'])) {
                        $field['fields'] = $existingField['fields'];
                    }
                }
            } elseif ($field['type'] === 'group') {
                $groupFields = [];
                foreach ($field as $key => $values) {
                    if (is_numeric($key)) {
                        $values['value'] = $this->initializeFieldValue($values);
                        $groupFields[$values['slug']] = $values;
                    }
                }
                $field['fields'] = $groupFields;
                $field = array_filter($field, fn($k) => !is_numeric($k), ARRAY_FILTER_USE_KEY);

                // If editing and we have existing group data, merge it
                if ($this->action === Action::UPDATE && isset($existingData[$field['slug']])) {
                    $existingField = $existingData[$field['slug']];
                    if (isset($existingField['fields']) && is_array($existingField['fields'])) {
                        foreach ($existingField['fields'] as $slug => $existingValue) {
                            if (isset($field['fields'][$slug])) {
                                $field['fields'][$slug]['value'] = $existingValue['value'] ?? $field['fields'][$slug]['value'];
                            }
                        }
                    }
                }
            } elseif ($field['type'] === 'checkbox') {
                $field['value'] = [];
            } elseif ($field['type'] === 'select') {
                $field['value'] = ($field['is_multiple'] ?? 'no') === 'yes' ? [] : null;
            } elseif ($field['type'] === 'file') {
                $field['value'] = ($field['is_multiple'] ?? 'no') === 'yes' ? [] : null;
            }

            // If editing and we have existing data for this field, merge it
            if ($this->action === Action::UPDATE && isset($existingData[$field['slug']])) {
                $existingField = $existingData[$field['slug']];

                // Merge existing values with field definition (for non-table/group fields)
                if ($field['type'] !== 'table' && $field['type'] !== 'group' && isset($existingField['value'])) {
                    $field['value'] = $existingField['value'];
                }

                // Handle file URLs for existing files
                if ($field['type'] === 'file') {
                    if (($field['is_multiple'] ?? 'no') === 'yes' && is_array($field['value'])) {
                        $field['urls'] = array_map(function ($filename) {
                            return FileFacade::getTemporaryUrl(
                                config('src.BusinessRegistration.businessRegistration.registration'),
                                $filename,
                                getStorageDisk('private')
                            );
                        }, $field['value']);
                    } elseif (is_string($field['value']) && !empty($field['value'])) {
                        $field['url'] = FileFacade::getTemporaryUrl(
                            config('src.BusinessRegistration.businessRegistration.registration'),
                            $field['value'],
                            getStorageDisk('private')
                        );
                    }
                }
            }

            return $field;
        })->mapWithKeys(function ($field) {
            return [$field['slug'] => $field];
        })->toArray();
    }

    public function setFields(int|string $registrationTypeId)
    {

        if (!is_numeric($registrationTypeId)) {
            $this->data = [];
            return;
        }
        $registrationType = RegistrationType::with('form')->find($registrationTypeId);
        $this->dispatch('init-registration-date');

        $this->registrationTypeEnum = $registrationType->registration_category_enum;
        $this->businessRegistration['registration_category'] = $registrationType->registration_category_enum;

        $this->requiredBusinessDocuments = config("src.BusinessRegistration.businessRequiredDocs.{$this->registrationTypeEnum}", []);


        if (!empty($registrationType->department_id)) {
            $this->hasDepartment = !$this->hasDepartment;
            $this->departmentUser = Branch::find($registrationType->department_id)?->users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                ];
            });
        }

        if (!$registrationType || !$registrationType->form) {
            $this->data = [];
            return;
        }

        if (!$registrationType->form->exists()) {
            $this->data = [];
            return;
        }

        // Store existing data for merging
        $existingData = $this->data;

        $this->data = $this->mergeExistingDataWithFields(
            json_decode($registrationType->form->fields, true),
            $existingData
        );
    }

    public function addTableRow(string $tableName): void
    {
        $tableKey = collect($this->data)
            ->search(fn($item) => isset($item['slug']) && $item['slug'] === $tableName);

        $table = $this->data[$tableKey];
        $newRow = array_map(function ($field) {
            $field['value'] = null;
            return $field;
        }, $table['fields'][0]);
        $this->data[$tableKey]['fields'][] = $newRow;
    }

    public function removeTableRow($tableName, $index): void
    {
        if (isset($this->data[$tableName]['fields'][$index])) {
            unset($this->data[$tableName]['fields'][$index]);
        }
    }

    private function getFormattedData(): array
    {

        $processedData = [];
        foreach ($this->data as $fieldSlug => $fieldValue) {
            if (isset($fieldValue['slug'])) {
                $fieldDefinition = collect($this->data)->firstWhere('slug', $this->data[$fieldValue['slug']]['slug']);

                if ($fieldDefinition && $fieldDefinition['type'] === 'table') {
                    $tableData = [];
                    foreach ($fieldValue['fields'] as $index => $field) {
                        $processedRow = [];
                        foreach ($field as $rowKey => $rowValue) {
                            if ($rowValue['type'] === 'file') {
                                $storedDocuments = [];

                                if (isset($rowValue['value'])) {
                                    $document = $rowValue['value'];

                                    if (is_array($document)) {
                                        foreach ($document as $file) {
                                            if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                                                $path = ImageServiceFacade::compressAndStoreImage(
                                                    $file,
                                                    config('src.BusinessRegistration.businessRegistration.registration'),
                                                    getStorageDisk('public')
                                                );
                                                $storedDocuments[] = $path;
                                            }
                                        }
                                    } else {
                                        if ($document instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                                            $path = ImageServiceFacade::compressAndStoreImage(
                                                $document,
                                                config('src.BusinessRegistration.businessRegistration.registration'),
                                                getStorageDisk('public')
                                            );
                                            $storedDocuments[] = $path;
                                        }
                                    }
                                }

                                $processedRow[$rowKey] = [
                                    'slug' => $rowValue['slug'],
                                    'type' => $rowValue['type'],
                                    'label' => $rowValue['label'] ?? '',
                                    'value' => $storedDocuments,
                                    'is_multiple' => $rowValue['is_multiple'] ?? 'no',
                                    'is_required' => $rowValue['is_required'] ?? 'no',
                                    'option' => $rowValue['option'] ?? [],
                                ];
                            } else {
                                $processedRow[$rowKey] = [
                                    'slug' => $rowValue['slug'],
                                    'type' => $rowValue['type'],
                                    'label' => $rowValue['label'] ?? '',
                                    'value' => $rowValue['value'] ?? null,
                                    'is_multiple' => $rowValue['is_multiple'] ?? 'no',
                                    'is_required' => $rowValue['is_required'] ?? 'no',
                                    'option' => $rowValue['option'] ?? [],
                                ];
                            }
                        }
                        if (!empty($processedRow)) {
                            $tableData[] = $processedRow;
                        }
                    }

                    $processedData[$fieldSlug] = [
                        'label' => $fieldDefinition['label'] ?? '',
                        'slug' => $fieldSlug,
                        'type' => 'table',
                        'fields' => $tableData
                    ];
                } elseif ($fieldDefinition['type'] === 'file' && is_array($fieldDefinition)) {
                    $storedDocuments = [];

                    if (isset($fieldDefinition['value'])) {
                        $document = $fieldDefinition['value'];

                        if (is_array($document)) {
                            foreach ($document as $file) {
                                if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                                    $path = ImageServiceFacade::compressAndStoreImage($file, config('src.BusinessRegistration.businessRegistration.registration'), getStorageDisk('public'));
                                    $storedDocuments[] = $path;
                                }
                            }
                        } else {
                            if ($document instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                                $path = ImageServiceFacade::compressAndStoreImage($document, config('src.BusinessRegistration.businessRegistration.registration'), getStorageDisk('public'));
                                $storedDocuments[] = $path;
                            }
                        }
                    }

                    $processedData[$fieldSlug] = array_merge(
                        $fieldDefinition ?? [],
                        [
                            'label' => $fieldDefinition['label'],
                            'value' => $storedDocuments,
                        ]
                    );
                } else {
                    $processedData[$fieldSlug] = array_merge($fieldDefinition ?? [], [
                        'value' => $fieldValue['value'] ?? null,
                        'label' => $fieldDefinition['label'] ?? '',
                    ]);
                }
            } else {
                logger("Slug not found for field: " . $fieldSlug);
            }
        }

        return $processedData;
    }

    private function processField($fieldDefinition, $fieldValue): array
    {
        if ($fieldDefinition['type'] === 'file') {
            return array_merge($fieldDefinition ?? [], [
                'label' => $fieldDefinition['label'],
                'value' => $this->processFileUploads($fieldValue['value'] ?? null),
            ]);
        }

        if ($fieldDefinition['type'] === 'select' && ($fieldDefinition['is_multiple'] ?? 'no') === 'yes') {
            return array_merge($fieldDefinition ?? [], [
                'value' => (array)($fieldValue['value'] ?? []),
                'label' => $fieldDefinition['label'] ?? '',
            ]);
        }

        if ($fieldDefinition['type'] === 'checkbox') {
            return array_merge($fieldDefinition ?? [], [
                'value' => (array)($fieldValue['selectedValues'] ?? []),
                'label' => $fieldDefinition['label'] ?? '',
            ]);
        }

        return array_merge($fieldDefinition ?? [], [
            'value' => $fieldValue['value'] ?? null,
            'label' => $fieldDefinition['label'] ?? '',
        ]);
    }

    private function processFileUploads($files): array
    {
        $storedDocuments = [];

        if (!$files) {
            return $storedDocuments;
        }

        $files = is_array($files) ? $files : [$files];

        foreach ($files as $file) {
            if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                $path = ImageServiceFacade::compressAndStoreImage(
                    $file,
                    config('src.BusinessRegistration.businessRegistration.registration'),
                    getStorageDisk('public')
                );
                $storedDocuments[] = $path;
            }
        }

        return $storedDocuments;
    }

    private function initializeFieldValue(array $field): mixed
    {
        return match ($field['type']) {
            'select' => ($field['is_multiple'] ?? 'no') === 'yes' ? [] : null,
            'checkbox' => [],
            'file' => ($field['is_multiple'] ?? 'no') === 'yes' ? [] : null,
            default => null
        };
    }

    public function updatedData($value, $name)
    {
        $parts = explode('.', $name);
        $fieldSlug = $parts[0];
        $fieldKey = $parts[1] ?? null;

        if (!isset($this->data[$fieldSlug])) return;
        $field = &$this->data[$fieldSlug];

        if ($field['type'] === 'file') {
            // Single file or multiple files
            $files = $field['value'];
            if (!$files) return;
            if (isset($field['is_multiple']) && $field['is_multiple'] === 'yes') {
                $urls = [];
                $filenames = [];
                foreach ((array)$files as $file) {
                    if ($file) {
                        $filename = FileFacade::saveFile(
                            path: config('src.BusinessRegistration.businessRegistration.registration'),
                            file: $file,
                            disk: 'local',
                            filename: ''
                        );
                        $filenames[] = $filename;
                        $urls[] = FileFacade::getTemporaryUrl(
                            path: config('src.BusinessRegistration.businessRegistration.registration'),
                            filename: $filename,
                            disk: getStorageDisk('private')
                        );
                    }
                }
                $field['value'] = $filenames;
                $field['urls'] = $urls;
            } else {
                $file = $files;
                if ($file) {
                    $filename = FileFacade::saveFile(
                        path: config('src.BusinessRegistration.businessRegistration.registration'),
                        file: $file,
                        disk: getStorageDisk('private'),
                        filename: ''
                    );
                    $field['value'] = $filename;
                    $field['url'] = FileFacade::getTemporaryUrl(
                        path: config('src.BusinessRegistration.businessRegistration.registration'),
                        filename: $filename,
                        disk: getStorageDisk('private')
                    );
                }
            }
        }
    }
}
