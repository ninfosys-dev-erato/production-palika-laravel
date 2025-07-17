<?php

namespace Src\BusinessRegistration\Livewire;

use App\Enums\Action;
use App\Facades\FileFacade;
use App\Facades\ImageServiceFacade;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use PDO;
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
            'businessRegistration.application_date.required' => __('businessregistration::businessregistration.application_date'),
            'businessRegistration.entity_name.required' => __('businessregistration::businessregistration.the_entity_name_is_required'),

            // Registration Type
            'businessRegistration.registration_type_id.required' => __('businessregistration::businessregistration.the_registration_type_is_required'),
            'businessRegistration.registration_type_id.exists' => __('businessregistration::businessregistration.the_registration_type_must_be_valid'),
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
        $this->fiscalYears = getFiscalYears()->pluck('year', 'id')->toArray();
        $this->provinces = getProvinces()->pluck('title', 'id')->toArray();
        $this->businessRegistration['fiscal_year_id'] = getCurrentFiscalYear()->id;
        $this->registrationTypes = RegistrationType::whereNull('deleted_at')->where('action', $businessRegistrationType)->pluck('title', 'id');



        $this->registrationCategories = RegistrationCategory::pluck('title', 'id')->toArray();

        $this->businessNatures = NatureOfBusiness::whereNull('deleted_at')->whereNull('deleted_by')->pluck('title', 'id')->toArray();
        $this->activeTab = 'personal';

        $this->genders = GenderEnum::getValuesWithLabels();
        $this->citizenshipDistricts = District::whereNull('deleted_at')->pluck('title', 'id');




        $this->departments = Branch::whereNull('deleted_at')->whereNull('deleted_by')->pluck('id', 'title')->toArray();

        if ($this->action == Action::UPDATE && $businessRegistration) {

            if (! $businessRegistration->relationLoaded('applicants')) {
                $businessRegistration->load('applicants');
            }
            if (! $businessRegistration->relationLoaded('requiredBusinessDocs')) {
                $businessRegistration->load('requiredBusinessDocs');
            }
            // if ($businessRegistration && !empty($businessRegistration->rentagreement)) {
            //     $this->handleFileUpload(
            //         file: $businessRegistration->rentagreement,
            //         field: 'rentagreement',
            //         target: 'businessRegistration'
            //     );
            // }

            if ($businessRegistration['registration_category'] == RegistrationCategoryEnum::BUSINESS->value) {
                $this->showRentFields = true;
            }

            if ($businessRegistration && !empty($businessRegistration->rentagreement)) {
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
                                'local'
                            ) : '',
                        'citizenship_rear_url' => $citizenshipRear
                            ? FileFacade::getTemporaryUrl(
                                config('src.BusinessRegistration.businessRegistration.registration'),
                                $citizenshipRear,
                                'local'
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

            // Load existing required business documents
            if ($businessRegistration->relationLoaded('requiredBusinessDocs')) {
                foreach ($businessRegistration->requiredBusinessDocs as $doc) {
                    $this->businessRequiredDoc[$doc->document_field] = $doc->document_filename;
                    $this->businessRequiredDocUrl[$doc->document_field . '_url'] = FileFacade::getTemporaryUrl(
                        config('src.BusinessRegistration.businessRegistration.registration'),
                        $doc->document_filename,
                        'local'
                    );
                }
            }
        }

        if ($registration && $registration->id) {
            $this->registrationType = $registration;
            $this->businessRegistration['category_id'] = $registration->registration_category_id;
            $this->businessRegistration['registration_type_id'] = $registration->id;
            $this->showCategory = false;
            $this->setFields($registration->id);
        }
        // if ($businessRegistrationType == BusinessRegistrationType::REGISTRATION) {
        //     $this->showData = true;
        // }

        // Ensure requiredBusinessDocuments is set on edit
        if ($this->businessRegistration && !empty($this->businessRegistration['registration_type_id'])) {
            $this->setFields($this->businessRegistration['registration_type_id']);
        }
    }



    public function addPersonalDetail()
    {
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
        ];
    }

    public function removePersonalDetail($index)
    {
        unset($this->personalDetails[$index]);
        $this->personalDetails = array_values($this->personalDetails); // reindex
    }



    public function setFields(int|string $registrationTypeId)
    {

        if (!is_numeric($registrationTypeId)) {
            $this->data = [];
            return;
        }
        $registrationType = RegistrationType::with('form')->find($registrationTypeId);

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




        $this->data = collect(json_decode($registrationType->form->fields, true))->map(function ($field) {
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
            } elseif ($field['type'] === 'group') {
                $fields = [];
                foreach ($field as $key => $values) {
                    if (is_numeric($key)) {
                        $values['value'] = $this->initializeFieldValue($values);
                        $fields[$values['slug']] = $values;
                    }
                }
                $field['fields'] = $fields;
                $field = array_filter($field, fn($k) => !is_numeric($k), ARRAY_FILTER_USE_KEY);
            } elseif ($field['type'] === 'checkbox') {
                $field['value'] = [];
            } elseif ($field['type'] === 'select') {
                $field['value'] = ($field['is_multiple'] ?? 'no') === 'yes' ? [] : null;
            } elseif ($field['type'] === 'file') {
                $field['value'] = ($field['is_multiple'] ?? 'no') === 'yes' ? [] : null;
                // If editing, generate URL(s) for existing value(s)
                if (!empty($field['value'])) {
                    if (($field['is_multiple'] ?? 'no') === 'yes' && is_array($field['value'])) {
                        $field['urls'] = array_map(function ($filename) {
                            return FileFacade::getTemporaryUrl(
                                config('src.BusinessRegistration.businessRegistration.registration'),
                                $filename,
                                'local'
                            );
                        }, $field['value']);
                    } elseif (is_string($field['value'])) {
                        $field['url'] = FileFacade::getTemporaryUrl(
                            config('src.BusinessRegistration.businessRegistration.registration'),
                            $field['value'],
                            'local'
                        );
                    }
                }
            }
            return $field;
        })->mapWithKeys(function ($field) {
            return [$field['slug'] => $field];
        })->toArray();
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
                                                    'local'
                                                );
                                                $storedDocuments[] = $path;
                                            }
                                        }
                                    } else {
                                        if ($document instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                                            $path = ImageServiceFacade::compressAndStoreImage(
                                                $document,
                                                config('src.BusinessRegistration.businessRegistration.registration'),
                                                'local'
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
                                    $path = ImageServiceFacade::compressAndStoreImage($file, config('src.BusinessRegistration.businessRegistration.registration'), 'local');
                                    $storedDocuments[] = $path;
                                }
                            }
                        } else {
                            if ($document instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                                $path = ImageServiceFacade::compressAndStoreImage($document, config('src.BusinessRegistration.businessRegistration.registration'), 'local');
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
                    'local'
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

    // public function getRegistrationTypes(int|string $id): void
    // {
    //     $this->registrationTypes = RegistrationType::where('registration_category_id', $id)->where('action', $this->businessRegistrationType)->pluck('id', 'title')->toArray();
    // }



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
        $this->activeTab = $tab;
    }
    public function rentStatusChanged($value)
    {
        $this->businessRegistration['is_rented'] = $value;

        $this->showRentFields = (int) $value === 1;
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


    // Add this method to handle file uploads for dynamic fields
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
                            disk: 'local'
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
                        disk: 'local',
                        filename: ''
                    );
                    $field['value'] = $filename;
                    $field['url'] = FileFacade::getTemporaryUrl(
                        path: config('src.BusinessRegistration.businessRegistration.registration'),
                        filename: $filename,
                        disk: 'local'
                    );
                }
            }
        }
    }

    private function handleFileUpload($file, $field, $index = null, $target = 'personal')
    {
        if (!$file) return;

        if (is_string($file)) {

            $filename = $file;
        } else {

            $filename = FileFacade::saveFile(
                path: config('src.BusinessRegistration.businessRegistration.registration'),
                file: $file,
                disk: 'local',
                filename: ''
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
            disk: 'local'
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
    public function save()
    {
        DB::beginTransaction();
        try {
            $this->validate();
            $this->businessRegistration['data'] = $this->getFormattedData();
            $this->businessRegistration['application_date_en'] = $this->bsToAd($this->businessRegistration['application_date']);

            $service = new BusinessRegistrationAdminService();
            $businessApplicantService = new BusinessRegistrationApplicantService();
            $businessRequiredDocService = new BusinessRequiredDocService();

            switch ($this->action) {
                case Action::CREATE:
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
                        return redirect()->route('admin.business-registration.business-registration.index', ['type' => $this->businessRegistrationType]);
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
                        return redirect()->route('admin.business-registration.business-registration.index', ['type' => $this->businessRegistrationType]);
                    } else {
                        DB::rollBack();
                        $this->errorFlash(____('businessregistration::businessregistration.business_registration_failed'));
                        return;
                    }

                default:
                    DB::rollBack();
                    $this->errorFlash(__('Invalid action.'));
                    return redirect()->route('admin.business-registration.business-registration.index', ['type' => $this->businessRegistrationType]);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            logger($e->getMessage());
            $this->errorFlash('Something went wrong while saving. ' . $e->getMessage());
        }
    }
}
