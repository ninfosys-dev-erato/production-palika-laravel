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
use Src\BusinessRegistration\Service\BusinessDeRegistrationService;
use Src\BusinessRegistration\Service\BusinessRegistrationAdminService;
use Src\BusinessRegistration\Service\BusinessRegistrationApplicantService;
use Src\BusinessRegistration\Service\BusinessRequiredDocService;
use Src\Customers\Enums\GenderEnum;
use Src\Employees\Models\Branch;
use Illuminate\Support\Facades\DB;
use Src\Address\Models\District;
use Src\BusinessRegistration\DTO\BusinessDeRegistrationDto;
use Src\BusinessRegistration\Enums\ApplicationStatusEnum;
use Src\BusinessRegistration\Models\BusinessDeRegistration;

class BusinessDeRegistrationForm extends Component
{
    use SessionFlash, WithFileUploads, HelperDate;

    public ?BusinessDeRegistration $businessDeRegistration;
    public ?Action $action;
    public ?RegistrationType $registrationType;

    public ?BusinessRegistration $businessRegistration;
    public $activeTab = 'personal';




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



    public function rules(): array
    {
        return [
            'businessDeRegistration.brs_registration_data_id' => ['nullable'],
            'businessDeRegistration.registration_type_id' => ['required'],
            'businessDeRegistration.fiscal_year' => ['required', 'string'],
            'businessDeRegistration.application_date' => ['required', 'string'],
            'businessDeRegistration.application_date_en' => ['nullable', 'string'],
            'businessDeRegistration.amount' => ['nullable', 'string'],
            'businessDeRegistration.application_rejection_reason' => ['nullable', 'string'],
            'businessDeRegistration.bill_no' => ['nullable', 'string'],
            'businessDeRegistration.registration_number' => ['nullable', 'string'],
            'businessDeRegistration.data' => ['nullable'],
            'businessDeRegistration.application_status' => ['nullable', 'string'],
            'businessDeRegistration.created_by' => ['nullable', 'integer'],
            'businessDeRegistration.updated_by' => ['nullable', 'integer'],
            'businessDeRegistration.deleted_at' => ['nullable'],
            'businessDeRegistration.deleted_by' => ['nullable', 'integer'],
            'businessDeRegistration.created_at' => ['nullable'],
            'businessDeRegistration.updated_at' => ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'businessDeRegistration.fiscal_year.required' => __('businessregistration::businessregistration.the_fiscal_year_is_required'),
            'businessDeRegistration.application_date.required' => __('businessregistration::businessregistration.application_date_is_required'),
            'businessDeRegistration.registration_type_id.required' => __('businessregistration::businessregistration.registration_type_id_is_required'),
            // Add more as needed
        ];
    }


    public function render(): View
    {
        return view('BusinessRegistration::livewire.business-deregistration.form');
    }

    public function mount(BusinessDeRegistration $businessDeRegistration, Action $action, ?BusinessRegistrationType $businessRegistrationType)
    {
        $this->businessDeRegistration = $businessDeRegistration;
        $this->businessRegistrationType = $businessRegistrationType;
        $this->action = $action;
        $this->fiscalYears = getFiscalYears()->pluck('year', 'id')->toArray();

        if ($this->action == Action::UPDATE) {
            $this->search = $this->businessDeRegistration->businessRegistration->entity_name;
            $this->searchBusiness();
            $this->setFields($this->businessDeRegistration->registration_type_id);
        }
    }


    public function searchBusiness()
    {
        $businessData = BusinessRegistration::with(
            'registrationType',
            'registrationType.registrationCategory',
            'requiredBusinessDocs',
            'applicants',
            'applicants.applicantProvince',
            'applicants.applicantDistrict',
            'applicants.applicantLocalBody',
            'applicants.citizenshipDistrict',
            'fiscalYear',
            'businessProvince',
            'businessDistrict',
            'businessLocalBody'
        )
            ->whereNull('deleted_at')
            ->where(function ($query) {
                $query->where('entity_name', $this->search)
                    ->orWhere('registration_number', $this->search);
            })
            ->where('application_status', ApplicationStatusEnum::ACCEPTED->value)
            ->first();


        if ($businessData) {
            if ($this->action == Action::CREATE) {
                // Check if a deregistration already exists for this business registration
                $deregistrationExists = BusinessDeregistration::where('brs_registration_data_id', $businessData->id)
                    ->whereNull('deleted_at')
                    ->exists();
                if ($deregistrationExists) {
                    $this->errorToast(__('businessregistration::businessregistration.deregistration_already_exists_for_this_business'));
                    return;
                }
            }

            $this->businessRegistration = $businessData;

            // Map applicants to personalDetails
            $this->personalDetails = $businessData->applicants
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
                        'citizenship_issued_district' => $applicant->citizenshipDistrict?->title,

                        'applicant_province' => $applicant->applicantProvince?->title,
                        'applicant_district' => $applicant->applicantDistrict?->title,
                        'applicant_local_body' => '',


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

            $this->requiredBusinessDocuments = $businessData->requiredBusinessDocs->map(function ($doc) {
                return [
                    'name' => $doc->document_label_ne,
                    'url' => FileFacade::getTemporaryUrl(
                        path: config('src.BusinessRegistration.businessRegistration.registration'),
                        filename: $doc->document_filename,
                        disk: 'local'
                    ),
                ];
            })->toArray();

            foreach (array_keys($this->personalDetails) as $index) {
                $this->getApplicantDistricts($index);
                $this->getApplicantLocalBodies($index);
                $this->getApplicantWards($index);
            }
            $this->getBusinessDistricts();
            $this->getBusinessLocalBodies();
            $this->getBusinessWards();
            $this->showData = true;

            $this->registrationTypes = RegistrationType::where('action', $this->businessRegistrationType)->pluck('title', 'id');
        } else {
            $this->errorToast('No Data found with this name');
        }
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
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

    public function getRegistrationTypes(int|string $id): void
    {
        $this->registrationTypes = RegistrationType::where('registration_category_id', $id)->where('action', $this->businessRegistrationType)->pluck('id', 'title')->toArray();
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



    public function rentStatusChanged($value)
    {
        $this->businessRegistration['is_rented'] = $value;

        $this->showRentFields = (int) $value === 1;
    }

    public function handleFileUpload($file, int $index, string $field)
    {
        if (!$file) {
            return;
        }

        $save = FileFacade::saveFile(
            path: config('src.BusinessRegistration.businessRegistration.registration'),
            file: $file,
            disk: "local",
            filename: ""
        );

        // Save file name in personalDetails
        $this->personalDetails[$index][$field] = $save;

        // Generate temporary URL
        $this->personalDetails[$index][$field . '_url'] = FileFacade::getTemporaryUrl(
            path: config('src.BusinessRegistration.businessRegistration.registration'),
            filename: $save,
            disk: 'local'
        );
    }

    public function updatedPersonalDetails($value, $name)
    {

        [$index, $field] = explode('.', $name);

        if (in_array($field, ['citizenship_front', 'citizenship_rear'])) {

            $file = $this->personalDetails[$index][$field] ?? null;


            $this->handleFileUpload($file, (int) $index, $field);
        }
    }

    public function updatedBusinessRequiredDoc($value, $field)
    {
        if (isset($this->requiredBusinessDocuments[$field])) {
            $this->uploadBusinessDocument($value, $field);
        }
    }

    public function uploadBusinessDocument($file, string $field)
    {
        if (!$file) return;

        try {
            $filename = FileFacade::saveFile(
                path: config('src.BusinessRegistration.businessRegistration.registration'),
                file: $file,
                disk: 'local',
                filename: ''
            );

            $this->businessRequiredDoc[$field] = $filename;

            $this->businessRequiredDocUrl[$field . '_url'] = FileFacade::getTemporaryUrl(
                path: config('src.BusinessRegistration.businessRegistration.registration'),
                filename: $filename,
                disk: 'local'
            );
        } catch (\Exception $e) {
            $this->errorFlash('Failed to upload document: ' . $e->getMessage());
        }
    }


    public function save()
    {

        DB::beginTransaction();
        try {
            $this->validate();
            $this->businessDeRegistration['data'] = $this->getFormattedData();
            $this->businessDeRegistration['application_date_en'] = $this->bsToAd($this->businessDeRegistration['application_date']);
            $this->businessDeRegistration['brs_registration_data_id'] = $this->businessRegistration->id;

            $service = new BusinessDeRegistrationService();
            $dto = BusinessDeRegistrationDto::fromLiveWireModel($this->businessDeRegistration);
            switch ($this->action) {

                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('businessregistration::businessregistration.business_deregistration_created_successfully'));
                    DB::commit();
                    return redirect()->route('admin.business-deregistration.index');

                case Action::UPDATE:
                    $service->update($this->businessDeRegistration, $dto);
                    $this->successFlash(__('businessregistration::businessregistration.business_deregistration_updated_successfully'));
                    DB::commit();
                    return redirect()->route('admin.business-deregistration.index');
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
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
}
