<?php

namespace Frontend\CustomerPortal\BusinessRegistrationAndRenewal\Livewire;

use App\Enums\Action;
use App\Facades\ImageServiceFacade;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\BusinessRegistration\DTO\BusinessRegistrationAdminDto;
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

    public array $registrationTypes = [];
    public array $data = [];
    public array $provinces = [];
    public array $districts = [];
    public array $localBodies = [];
    public array $wards = [];
    public array $fiscalYears = [];
    public array $registrationCategories = [];
    public array $businessNatures = [];
    public array $departments = [];

    public function rules(): array
    {
        $rules = [
            'businessRegistration.registration_type_id' => ['required', Rule::exists('brs_registration_types', 'id')],
            'businessRegistration.entity_name' => ['required'],
            'businessRegistration.province_id' => ['required', Rule::exists('add_provinces', 'id')],
            'businessRegistration.district_id' => ['required', Rule::exists('add_districts', 'id')],
            'businessRegistration.local_body_id' => ['required', Rule::exists('add_local_bodies', 'id')],
            'businessRegistration.ward_no' => ['required'],
            'businessRegistration.tole' => ['sometimes', 'nullable'],
            'businessRegistration.way' => ['sometimes', 'nullable'],
            'businessRegistration.data' => ['sometimes', 'nullable'],
            'businessRegistration.fiscal_year_id' => ['required', Rule::exists('mst_fiscal_years', 'id')],
            'businessRegistration.mobile_no' => ['sometimes', 'nullable'],
            'businessRegistration.business_nature' => [ 'nullable'],
        ];

        return $rules;
    }

    public function render(): View
    {
        return view('CustomerPortal.BusinessRegistrationAndRenewal::livewire.business-registration.form');
    }

    public function mount(BusinessRegistration $businessRegistration, Action $action)
    {
        $this->businessRegistration = $businessRegistration;
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
            $this->data = $businessRegistration->data ??  [];
        }
    }

    public function setFields(int|string $registrationTypeId): void
    {
        if (!is_numeric($registrationTypeId)) {
            $this->data = [];
            return;
        }
        $registrationType = RegistrationType::with('form')->find($registrationTypeId);

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

    public function getRegistrationTypes(int|string $id): void
    {
        $this->registrationTypes = RegistrationType::where('registration_category_id', $id)->pluck('id', 'title')->toArray();
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

        // $this->chooseRandomUsers();
        try{
            $this->businessRegistration['data'] = $this->getFormattedData();
            
            $dto = BusinessRegistrationAdminDto::fromLiveWireModel($this->businessRegistration);

            $service = new BusinessRegistrationAdminService();

            switch ($this->action) {
                case Action::CREATE:
                    $application_date_en = date('Y-m-d');
                    $application_date = $this->adToBs($application_date_en);

                    $this->businessRegistration['application_date_en'] = $application_date_en;
                    $this->businessRegistration['application_date'] = $application_date;
                    $service->store($dto);
                    $this->successFlash(__("Business Registration Application Submitted Successfully"));
                    return redirect()->route('customer.business-registration.business-registration.index');
                case Action::UPDATE:
                    $service->update($dto, $this->businessRegistration);
                    $this->successFlash(__("Business Registration Application Updated Successfully"));
                    return redirect()->route('customer.business-registration.business-registration.index');

                default:
                    return redirect()->route('customer.business-registration.business-registration.index');
            }

        } catch (\Exception $e) {
            logger()->error($e);
            $this->errorFlash('Something went wrong while rejecting.', $e->getMessage());
        }
        
    }

    // public function chooseRandomUsers()
    // {
    //     if ($this->businessRegistration['registration_type_id']) {
    //         $registrationType = $this->businessRegistration->registrationType;
            
    //         if ($registrationType && !empty($registrationType->department_id)) {
    //             $branch = $registrationType->branch; 
        
    //             if ($branch) {
    //                 $branchUsers = $branch->users;
        
    //                 if ($branchUsers->count() >= 3) {
                        
    //                     $randomUsers = $branchUsers->random(3);
    //                 } else {
    //                     $randomUsers = $branchUsers->shuffle()->pad(3, null);
    //                 }
    //                 $this->businessRegistration['operator_id'] = $randomUsers[0]->id ?? null;
    //                 $this->businessRegistration['preparer_id']  = $randomUsers[1]->id ?? null;
    //                 $this->businessRegistration['approver_id'] = $randomUsers[2]->id ?? null;
    //             }
    //         }
    //     }
    // }
}
