<?php

namespace Src\BusinessRegistration\Livewire;

use App\Enums\Action;
use App\Facades\ImageServiceFacade;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use PDO;
use Src\BusinessRegistration\DTO\BusinessRegistrationAdminDto;
use Src\BusinessRegistration\Enums\BusinessRegistrationType;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Src\BusinessRegistration\Models\NatureOfBusiness;
use Src\BusinessRegistration\Models\RegistrationCategory;
use Src\BusinessRegistration\Models\RegistrationType;
use Src\BusinessRegistration\Service\BusinessRegistrationAdminService;
use Src\Employees\Models\Branch;

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
    public $fiscalYears = [];
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

    public function rules(): array
    {
        $rules = [
            'businessRegistration.registration_type_id' => ['required', Rule::exists('brs_registration_types', 'id')],
            'businessRegistration.entity_name' => ['required'],
            'businessRegistration.applicant_name' => ['required'],
            'businessRegistration.applicant_number' => ['required', 'numeric'],
            'businessRegistration.province_id' => ['required', Rule::exists('add_provinces', 'id')],
            'businessRegistration.district_id' => ['required', Rule::exists('add_districts', 'id')],
            'businessRegistration.local_body_id' => ['required', Rule::exists('add_local_bodies', 'id')],
            'businessRegistration.ward_no' => ['required'],
            'businessRegistration.tole' => ['sometimes', 'nullable'],
            'businessRegistration.way' => ['sometimes', 'nullable'],
            'businessRegistration.data' => ['sometimes', 'nullable'],
            'businessRegistration.fiscal_year_id' => ['required', Rule::exists('mst_fiscal_years', 'id')],
            'businessRegistration.mobile_no' => ['sometimes', 'nullable'],
            'businessRegistration.application_date' => ['required'],
            'businessRegistration.business_nature' => ['nullable'],
            'businessRegistration.department_id' => ['nullable'],
        ];

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
            'businessRegistration.registration_type_id.required' => __('businessregistration::businessregistration.the_registration_type_is_required'),
            'businessRegistration.applicant_name.required' => __('businessregistration::businessregistration.the_applicant_name_is_required'),
            'businessRegistration.applicant_number.required' => __('businessregistration::businessregistration.the_applicant_number_is_required'),
            'businessRegistration.registration_type_id.exists' => __('businessregistration::businessregistration.the_selected_registration_type_is_invalid'),
            'businessRegistration.category_id.required' => __('businessregistration::businessregistration.the_category_is_required'),
            'businessRegistration.category_id.exists' => __('businessregistration::businessregistration.the_selected_category_is_invalid'),
            'businessRegistration.entity_name.required' => __('businessregistration::businessregistration.the_entity_name_is_required'),
            'businessRegistration.province_id.required' => __('businessregistration::businessregistration.the_province_is_required'),
            'businessRegistration.province_id.exists' => __('businessregistration::businessregistration.the_selected_province_is_invalid'),
            'businessRegistration.district_id.required' => __('businessregistration::businessregistration.the_district_is_required'),
            'businessRegistration.district_id.exists' => __('businessregistration::businessregistration.the_selected_district_is_invalid'),
            'businessRegistration.local_body_id.required' => __('businessregistration::businessregistration.the_local_body_is_required'),
            'businessRegistration.local_body_id.exists' => __('businessregistration::businessregistration.the_selected_local_body_is_invalid'),
            'businessRegistration.ward_no.required' => __('businessregistration::businessregistration.the_ward_number_is_required'),
            'businessRegistration.tole.sometimes' => __('businessregistration::businessregistration.the_tole_is_optional'),
            'businessRegistration.way.sometimes' => __('businessregistration::businessregistration.the_way_is_optional'),
            'businessRegistration.data.sometimes' => __('businessregistration::businessregistration.the_data_is_optional'),
            'businessRegistration.fiscal_year_id.required' => __('businessregistration::businessregistration.the_fiscal_year_is_required'),
            'businessRegistration.fiscal_year_id.exists' => __('businessregistration::businessregistration.the_selected_fiscal_year_is_invalid'),
            'businessRegistration.mobile_no.sometimes' => __('businessregistration::businessregistration.the_mobile_number_is_optional'),
            'businessRegistration.application_date.required' => __('businessregistration::businessregistration.the_application_date_is_required'),
            'businessRegistration.operator_id.required' => __('businessregistration::businessregistration.the_field_is_required'),
            'businessRegistration.preparer_id.required' => __('businessregistration::businessregistration.the_field_is_required'),
            'businessRegistration.approver_id.required' => __('businessregistration::businessregistration.the_field_is_required'),

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
        $this->registrationCategories = RegistrationCategory::pluck('title', 'id')->toArray();
        $this->businessNatures = NatureOfBusiness::whereNull('deleted_at')->whereNull('deleted_by')->pluck('id', 'title')->toArray();
        $this->departments = Branch::whereNull('deleted_at')->whereNull('deleted_by')->pluck('id', 'title')->toArray();

        if ($this->action == Action::UPDATE) {
            $this->getDistricts();
            $this->getWards();
            $this->data = $businessRegistration->data ?? [];
        }

        if ($registration && $registration->id) {
            $this->registrationType = $registration;
            $this->businessRegistration['category_id'] = $registration->registration_category_id;
            $this->businessRegistration['registration_type_id'] = $registration->id;
            $this->showCategory = false;
            $this->setFields($registration->id);
        }
        if ($businessRegistrationType == BusinessRegistrationType::REGISTRATION) {
            $this->showData = true;
        }
    }



    public function searchBusiness()
    {
        $businessData = BusinessRegistration::with('registrationType', 'registrationType.registrationCategory')
            ->whereNull('deleted_at')
            ->whereNull('deleted_by')
            ->where('entity_name', $this->search)
            ->orWhere('registration_number', $this->search)
            ->first();
        if ($businessData) {
            $this->businessRegistration = $businessData;
            $this->businessRegistration->fiscal_year_id = getCurrentFiscalYear()->id;;

            $this->getDistricts();
            $this->getWards();
            $this->action =  Action::CREATE;
            $this->showData = true;
            $this->registrationCategory =  $businessData->registrationType->registrationCategory->id;


            if ($this->registrationCategory) {
                $this->getRegistrationTypes($this->registrationCategory);


                if (!empty($this->registrationTypes)) {
                    $firstId = array_values($this->registrationTypes)[0]; //gets the 1st value of registration type
                    $this->businessRegistration->registration_type_id = $firstId;
                    $this->setFields($firstId);
                }
            }
        } else {
            $this->errorToast('No Data found with this name');
        }
    }
    public function setFields(int|string $registrationTypeId)
    {
        if (!is_numeric($registrationTypeId)) {
            $this->data = [];
            return;
        }
        $registrationType = RegistrationType::with('form')->find($registrationTypeId);

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

    public function getDistricts(): void
    {
        $this->districts = getDistricts($this->businessRegistration['province_id'])->pluck('title', 'id')->toArray();
        $this->localBodies = [];
        $this->wards = [];
    }

    public function getLocalBodies(): void
    {
        $this->localBodies = getLocalBodies($this->businessRegistration['district_id'])->pluck('title', 'id')->toArray();
        $this->wards = [];
    }

    public function getWards(): void
    {
        $this->wards = getWards(getLocalBodies(localBodyId: $this->businessRegistration['local_body_id'])->wards);
    }

    public function save()
    {
        $this->validate();

        $this->businessRegistration['data'] = $this->getFormattedData();


        $this->businessRegistration['application_date_en'] = $this->bsToAd($this->businessRegistration['application_date']);

        try {
            $service = new BusinessRegistrationAdminService();

            switch ($this->action) {
                case Action::CREATE:
                    switch ($this->businessRegistrationType) {
                        case BusinessRegistrationType::DEREGISTRATION:
                            $dto = BusinessRegistrationAdminDto::fromDeRegistrationLiveWireModel(businessRegistration: $this->businessRegistration, admin: true);
                            $success = $service->deRegisterBusiness($dto, $this->businessRegistration);
                            if ($success) {
                                $this->successFlash(__('Business DeRegistration successful'));
                            } else {
                                $this->errorFlash(__('Business DeRegistration failed'));
                            }
                            break;
                        default:
                            $dto = BusinessRegistrationAdminDto::fromLiveWireModel(businessRegistration: $this->businessRegistration, admin: true);
                            $success = $service->store($dto);
                            if ($success instanceof BusinessRegistration) {
                                $this->successFlash(__('Business Registration successful'));
                            } else {
                                $this->errorFlash(__('Business Registration failed'));
                            }
                            break;
                    }
                    return redirect()->route('admin.business-registration.business-registration.index', ['type' => $this->businessRegistrationType]);

                case Action::UPDATE:
                    $dto = BusinessRegistrationAdminDto::fromLiveWireModel(businessRegistration: $this->businessRegistration, admin: true);
                    $success = $service->update($dto, $this->businessRegistration);
                    if ($success instanceof BusinessRegistration) {
                        $this->successFlash(__('businessregistration::businessregistration.business_registration_application_updated_successfully'));
                    } else {
                        $this->errorFlash(__('Business registration update  failed'));
                    }

                    return redirect()->route('admin.business-registration.business-registration.index', ['type' => $this->businessRegistrationType]);

                default:
                    return redirect()->route('admin.business-registration.business-registration.index', ['type' => $this->businessRegistrationType]);
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
    /**
     * this function is used to make input field readonly
     * checks type and return true if matches and make input filed readonly
     */
    public function getIsReadonlyProperty(): bool
    {
        return $this->businessRegistrationType === BusinessRegistrationType::DEREGISTRATION;
    }
}
