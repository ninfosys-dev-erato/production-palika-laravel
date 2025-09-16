<?php

namespace Frontend\BusinessPortal\Ebps\Livewire;

use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use App\Traits\HelperTemplate;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\Ebps\DTO\CantileverDetailAdminDto;
use Src\Ebps\DTO\DistanceToWallAdminDto;
use Src\Ebps\DTO\HighTensionLineDetailAdminDto;
use Src\Ebps\DTO\MapApplyDetailAdminDto;
use Src\Ebps\DTO\RoadAdminDto;
use Src\Ebps\DTO\StoreyDetailAdminDto;
use Src\Ebps\Enums\AcceptanceTypeEnum;
use Src\Ebps\Enums\PurposeOfConstructionEnum;
use Src\Ebps\Models\BuildingConstructionType;
use Src\Ebps\Models\BuildingRoofType;
use Src\Ebps\Models\LandUseArea;
use Src\Ebps\Models\MapApply;
use Src\Ebps\Models\MapApplyDetail;
use Src\Ebps\Models\Storey;
use Src\Ebps\Service\CantileverDetailAdminService;
use Src\Ebps\Service\DistanceToWallAdminService;
use Src\Ebps\Service\HighTensionLineDetailAdminService;
use Src\Ebps\Service\MapApplyDetailAdminService;
use Src\Ebps\Service\RoadAdminService;
use Src\Ebps\Service\StoreyDetailAdminService;
use Src\Ebps\Models\AdditionalForm;
use App\Enums\Action;
use App\Facades\FileFacade;
use App\Facades\ImageServiceFacade;
use App\Traits\MapApplyTrait;
use Src\Ebps\DTO\AdditionalFormDynamicDataDto;
use Src\Ebps\Service\AdditionalFormDynamicDataService;
use Src\Ebps\Models\AdditionalFormDynamicData;
use Src\Settings\Models\Form;

class OrganizationCustomerDetailForm extends Component
{
    use WithFileUploads, SessionFlash, HelperDate, HelperTemplate, MapApplyTrait;

    public ?MapApply $mapApply;
    public ?MapApplyDetail $mapApplyDetail;
    public int $currentStep = 1;
    public float $progressPercentage = 0;
    public array $districts = [];
    public array $provinces = [];
    public array $localBodies = [];
    public array $wards = [];
    public Collection $landUseAreas;
    public array $constructionPurposes = [];
    public array $acceptanceTypes = [];
    public Collection $storeys;
    public array $constructionStoreyPurpose = [];
    public float $totalPurposedArea = 0;
    public float $totalFormerArea = 0;
    public float $totalCombinedArea = 0;
    public float $totalHeight = 0;
    public Collection $buildingConstructionTypes;
    public Collection $buildingRoofTypes;
    public array $distanceToWall = [];
    public array $roads = [];
    public array $cantileverDetails = [];
    public array $highTensionDetails = [];
    public $todayDate;

    public Action $action = Action::CREATE;

    public  array $additionalFormsTemplate;
    public $editMode = false;
    public $hasUnsavedChanges = false;
    public $editingFormId = null;
    public $editingTemplate = '';
    public $preview = true;
    public $editingTemplates = [];
    public $currentEditingTemplate = '';
    public $activeFormId = null;
    public $formStyles = '';
    public array $placeholders = [];

    public function rules(): array
    {
        $rules =  [
            'mapApplyDetail.organization_id'              => ['nullable', 'string'],
            'mapApplyDetail.land_use_area_id'             => ['nullable', 'string'],
            'mapApplyDetail.land_use_area_changes'        => ['nullable', 'string'],
            'mapApplyDetail.usage_changes'                => ['nullable', 'string'],
            'mapApplyDetail.change_acceptance_type'       => ['nullable', 'string'],
            'mapApplyDetail.field_measurement_area'       => ['nullable', 'string'],
            'mapApplyDetail.building_plinth_area'         => ['nullable', 'string'],
            'mapApplyDetail.building_construction_type_id' => ['nullable', 'string'],
            'mapApplyDetail.construction_purpose_id'      => ['nullable', 'string'],
            'mapApplyDetail.building_roof_type_id'        => ['nullable', 'string'],
            'mapApplyDetail.other_construction_area'      => ['nullable', 'string'],
            'mapApplyDetail.former_other_construction_area' => ['nullable', 'string'],
            'mapApplyDetail.public_property_name'         => ['nullable', 'string'],
            'mapApplyDetail.material_used'                => ['nullable', 'string'],
            'mapApplyDetail.distance_left'                => ['nullable', 'string'],
            'mapApplyDetail.area_unit'                    => ['nullable', 'string'],
            'mapApplyDetail.length_unit'                  => ['nullable', 'string'],
        ];

        foreach ($this->constructionStoreyPurpose as $index => $purpose) {
            $rules["constructionStoreyPurpose.$index.storey_id"] = 'nullable|exists:ebps_storeys,id';
            $rules["constructionStoreyPurpose.$index.purposed_area"] = 'nullable|numeric|min:0';
            $rules["constructionStoreyPurpose.$index.former_area"] = 'nullable|numeric|min:0';
            $rules["constructionStoreyPurpose.$index.height"] = 'nullable|numeric|min:0';
            $rules["constructionStoreyPurpose.$index.remarks"] = 'nullable|string';
        }


        foreach ($this->roads as $index => $label) {
            $rules["roads.$index.width"] = 'nullable|numeric';
            $rules["roads.$index.dist_from_middle"] = 'nullable|numeric';
            $rules["roads.$index.min_dist_from_middle"] = 'nullable|numeric';
            $rules["roads.$index.dist_from_side"] = 'nullable|numeric';
            $rules["roads.$index.min_dist_from_side"] = 'nullable|numeric';
            $rules["roads.$index.dist_from_right"] = 'nullable|numeric';
            $rules["roads.$index.min_dist_from_right"] = 'nullable|numeric';
            $rules["roads.$index.setback"] = 'nullable|numeric';
            $rules["roads.$index.min_setback"] = 'nullable|numeric';
        }

        foreach ($this->distanceToWall as $index => $label) {

            $rules["distanceToWall.$index.direction"] = 'nullable|string';
            $rules["distanceToWall.$index.has_road"] = 'required';
            $rules["distanceToWall.$index.does_have_wall_door"] = 'required';
            $rules["distanceToWall.$index.dist_left"] = 'required|numeric|min:0';
            $rules["distanceToWall.$index.min_dist_left"] = 'required|numeric|min:0';
        }

        foreach ($this->cantileverDetails as $index => $label) {
            $rules["cantileverDetails.$index.direction"] = 'nullable|string';
            $rules["cantileverDetails.$index.distance"] = 'nullable|numeric|min:0';
            $rules["cantileverDetails.$index.minimum"] = 'nullable|numeric|min:0';
        }


        foreach ($this->highTensionDetails as $direction => $highTensionData) {
            $rules["highTensionDetails.$direction.distance"] = 'nullable|numeric|min:0';
            $rules["highTensionDetails.$direction.voltage"] = 'nullable|string';
            $rules["highTensionDetails.$direction.remarks"] = 'nullable|string';
        }


        return $rules;
    }

    public function mount(MapApply $mapApply, MapApplyDetail $mapApplyDetail): void
    {
        // Set action based on whether we're creating or updating
        $this->action = $mapApplyDetail->exists ? Action::UPDATE : Action::CREATE;

        $this->mapApply = $mapApply->load(
            'landDetail',
            'constructionType',
            'fiscalYear',
            'mapApplySteps',
            'storeyDetails',
            'distanceToWalls',
            'roads',
            'cantileverDetails',
            'highTensionLineDetails'
        );

        $this->mapApplyDetail = MapApplyDetail::where('map_apply_id', $mapApply->id)->first();
        $this->constructionStoreyPurpose = $this->mapApply->storeyDetails->isNotEmpty() ? $this->mapApply->storeyDetails->toArray() : [];
        $this->distanceToWall = $this->mapApply->distanceToWalls->isNotEmpty()
            ? $this->mapApply->distanceToWalls->mapWithKeys(function ($item) {
                return [$item['direction'] => $item];
            })->toArray()
            : [];
        $this->roads = $this->mapApply->roads->isNotEmpty()
            ? $this->mapApply->roads->mapWithKeys(function ($item) {
                return [$item['direction'] => $item];
            })->toArray()
            : [];


        $this->cantileverDetails = $this->mapApply->cantileverDetails->isNotEmpty()
            ? $this->mapApply->cantileverDetails->mapWithKeys(function ($item) {
                return [$item['direction'] => $item];
            })->toArray()
            : [];
        $this->highTensionDetails = $this->mapApply->highTensionLineDetails->isNotEmpty()
            ? $this->mapApply->highTensionLineDetails->mapWithKeys(function ($item) {
                return [$item['direction'] => $item];
            })->toArray()
            : [];

        $this->landUseAreas = LandUseArea::whereNull('deleted_at')->get();
        $this->constructionPurposes = PurposeOfConstructionEnum::getValuesWithLabels();
        $this->acceptanceTypes = AcceptanceTypeEnum::getValuesWithLabels();
        $this->storeys = Storey::whereNull('deleted_at')->get();
        $this->buildingConstructionTypes = BuildingConstructionType::whereNull('deleted_at')->get();
        $this->buildingRoofTypes = BuildingRoofType::whereNull('deleted_at')->get();
        $this->todayDate = $this->convertEnglishToNepali(\Carbon\Carbon::today()->toDateString());

        // Initialize dynamic form fields from AdditionalForm
        // $this->setFields();

        $this->getAdditionalForms();
    }




    public function updateTotalArea($index)
    {
        $purposed = floatval($this->constructionStoreyPurpose[$index]['purposed_area'] ?? 0);
        $former = floatval($this->constructionStoreyPurpose[$index]['former_area'] ?? 0);

        $this->constructionStoreyPurpose[$index]['total_area'] = $purposed + $former;

        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->totalPurposedArea = 0;
        $this->totalFormerArea = 0;
        $this->totalCombinedArea = 0;
        $this->totalHeight = 0;

        foreach ($this->constructionStoreyPurpose as $item) {
            $this->totalPurposedArea += floatval($item['purposed_area'] ?? 0);
            $this->totalFormerArea += floatval($item['former_area'] ?? 0);
            $this->totalCombinedArea += floatval($item['total_area'] ?? 0);
            $this->totalHeight += floatval($item['height'] ?? 0);
        }
    }

    public function render(): Factory|View|Application
    {
        return view("BusinessPortal.Ebps::livewire.template");
    }


    public function addStoreyPurpose()
    {
        $this->constructionStoreyPurpose[] = [
            'storey_id' => null,
            'purposed_area' => null,
            'former_area' => null,
            'total_area' => 0,
            'height' => null,
            'remarks' => '',
        ];

        $index = array_key_last($this->constructionStoreyPurpose);
        $this->calculateTotals();
    }

    public function removeStoreyPurpose($index)
    {
        unset($this->constructionStoreyPurpose[$index]);
        $this->constructionStoreyPurpose = array_values($this->constructionStoreyPurpose);

        $this->calculateTotals();
    }

    public function save()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $dto = MapApplyDetailAdminDto::fromLiveWireModel($this->mapApplyDetail);
            $service = new MapApplyDetailAdminService();
            $storeyService = new StoreyDetailAdminService();
            $distacneToWallservice = new DistanceToWallAdminService();
            $cantileverService = new CantileverDetailAdminService();
            $highTensionService = new HighTensionLineDetailAdminService();

            $roadService = new RoadAdminService();
            $detail = $service->update($this->mapApplyDetail, $dto);

            $mapApplyId = $detail->map_apply_id;
            $cantileverService->deleteByMapApplyId($mapApplyId);
            $roadService->deleteByMapApplyId($mapApplyId);
            $storeyService->deleteByMapApplyId($mapApplyId);
            $distacneToWallservice->deleteByMapApplyId($mapApplyId);
            $highTensionService->deleteByMapApplyId($mapApplyId);

            foreach ($this->constructionStoreyPurpose as $storeyData) {
                $storeyData['map_apply_id'] = $mapApplyId;
                $storeyDto = StoreyDetailAdminDto::fromArray($storeyData);
                $storeyService->store($storeyDto);
            }

            foreach ($this->distanceToWall as $direction => $wallData) {
                $wallData['map_apply_id'] = $mapApplyId;
                $wallData['direction'] = $direction;
                $wallDto = DistanceToWallAdminDto::fromArray($wallData);
                $distacneToWallservice->store($wallDto);
            }
            foreach ($this->roads as $direction => $roadData) {

                $roadData['map_apply_id'] = $mapApplyId;
                $roadData['direction'] = $direction;
                $roadDto = RoadAdminDto::fromArray($roadData);
                $roadService->store($roadDto);
            }
            foreach ($this->cantileverDetails as $direction => $cantileverData) {
                $cantileverData['map_apply_id'] = $mapApplyId;
                $cantileverData['direction'] = $direction;
                $cantileverDto = CantileverDetailAdminDto::fromArray($cantileverData);
                $cantileverService->store($cantileverDto);
            }
            foreach ($this->highTensionDetails as $direction => $highTensionData) {
                $highTensionData['map_apply_id'] = $mapApplyId;
                $highTensionData['direction'] = $direction;
                $highTensionDto = HighTensionLineDetailAdminDto::fromArray($highTensionData);
                $highTensionService->store($highTensionDto);
            }

            DB::commit();
            $this->successToast("Map Apply Detail Created Successfully");
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            $this->errorToast(__("An error occurred during operation. Please try again later"));
        }
    }


    public function getAdditionalForms()
    {
        $additionalForms = AdditionalForm::with('form')->where('status', true)->get();

        $existingData = AdditionalFormDynamicData::where('map_apply_id', $this->mapApply->id)
            ->pluck('form_data', 'form_id')
            ->toArray();
        $existingDataDecoded = array_map(fn($item) => json_decode($item, true) ?? [], $existingData);

        $this->additionalFormsTemplate = $additionalForms->mapWithKeys(function ($additionalForm) use ($existingData, $existingDataDecoded) {
            $submittedDynamicData = $existingDataDecoded[$additionalForm->form?->id] ?? [];
            $id = $additionalForm->id;

            $template = $this->resolveMapStepTemplate($this->mapApply, null, $additionalForm->form, $submittedDynamicData);

            return [
                $id => [
                    'id' => $id,
                    'name' => $additionalForm->name,
                    'form_id' => $additionalForm->form?->id,
                    'template' => $template,
                    'style' => $additionalForm->form?->styles,
                    'is_saved' => isset($existingData[$additionalForm->form?->id]),
                    'submitted_data' => $submittedDynamicData,
                ]
            ];
        })->toArray();

        $this->formStyles = collect($this->additionalFormsTemplate)
            ->pluck('style')
            ->implode("\n");

        if (!empty($this->additionalFormsTemplate)) {
            $this->activeFormId = 'custom';

            // Initialize placeholders with the first form's data
            // $this->placeholders = $this->additionalFormsTemplate[$this->activeFormId]['submitted_data'] ?? [];
            // $template = $this->additionalFormsTemplate[$this->activeFormId]['template'] ?? '';
            // $this->currentEditingTemplate = $this->preview ? $this->replaceInputFieldsWithValues($template) : $template;
        }
    }


    public function togglePreview()
    {
        $this->preview = !$this->preview;
        $this->editMode = !$this->preview;

        if ($this->preview) {
            $template = $this->additionalFormsTemplate[$this->activeFormId]['template'];
            $this->currentEditingTemplate = $this->replaceInputFieldsWithValues($template);
        } else {
            $additionalForm = $this->additionalFormsTemplate[$this->activeFormId];
            $submittedData = $additionalForm['submitted_data'] ?? [];

            $this->currentEditingTemplate = $this->resolveMapStepTemplate(
                $this->mapApply,
                null,
                Form::find($additionalForm['form_id']),
                $submittedData
            );
        }
    }


    public function switchToForm($formId)
    {
        // Switch to new form
        $this->activeFormId = $formId;

        if ($formId === 'custom') {
            // Load custom form template
            $template = $this->customFormTemplate ?? '';
            $this->placeholders = $this->customFormData ?? [];
        } else {

            // Load the submitted data for this form into placeholders
            $this->placeholders = $this->additionalFormsTemplate[$this->activeFormId]['submitted_data'] ?? [];

            // Get the template
            $template = $this->additionalFormsTemplate[$this->activeFormId]['template'] ?? '';

            // Apply preview mode if needed
            if ($this->preview) {
                $this->currentEditingTemplate = $this->replaceInputFieldsWithValues($template);
            } else {
                $this->currentEditingTemplate = $template;
            }
        }

        // $this->dispatch('update-editor', ['currentEditingTemplate' => $this->currentEditingTemplate]);

        // Always show preview mode when switching tabs
        $this->preview = true;
        $this->editMode = false;
    }






    public function writeAdditionalFormTemplate()
    {
        try {

            $additionalForm = AdditionalForm::with('form')->find($this->activeFormId);
            if (!$additionalForm || !$additionalForm->form) {
                $this->errorToast('Form not found.');
                return;
            }

            $this->additionalFormsTemplate[$this->activeFormId]['is_saved'] = true;
            $this->additionalFormsTemplate[$this->activeFormId]['submitted_data'] = $this->placeholders;

            $dynamicDataDto = new AdditionalFormDynamicDataDto(
                map_apply_id: $this->mapApply->id,
                form_id: $additionalForm->form->id,
                form_data: json_encode($this->placeholders)
            );

            $dynamicDataService = new AdditionalFormDynamicDataService();
            $dynamicDataService->updateOrCreate($dynamicDataDto);

            $this->preview = true;
            $this->editMode = false;

            // Update the template to reflect the saved data
            $template = $this->additionalFormsTemplate[$this->activeFormId]['template'] ?? '';
            $this->currentEditingTemplate = $this->replaceInputFieldsWithValues($template);

            $this->successToast('Template saved successfully.');
        } catch (\Exception $e) {
            $this->errorToast('Failed to save template.');
        }
    }

    public function resetLetter()
    {
        try {
            if (!$this->activeFormId) return;

            $additionalForm = AdditionalForm::with('form')->find($this->activeFormId);
            if (!$additionalForm || !$additionalForm->form) {
                $this->errorToast('Form not found.');
                return;
            }

            $dynamicDataService = new AdditionalFormDynamicDataService();
            $existingData = $dynamicDataService->findByMapApplyAndForm($this->mapApply->id, $additionalForm->form_id);

            if ($existingData) {
                $dynamicDataService->deleteFormData($existingData);
            }

            // Reset is_saved and clear placeholders
            $this->additionalFormsTemplate[$this->activeFormId]['is_saved'] = false;
            $this->additionalFormsTemplate[$this->activeFormId]['submitted_data'] = [];
            $this->placeholders = [];

            // Regenerate template with empty data and update based on current mode
            $newTemplate = $this->resolveMapStepTemplate($this->mapApply, null, $additionalForm->form) ?? '';
            $this->additionalFormsTemplate[$this->activeFormId]['template'] = $newTemplate;

            // Apply preview mode transformation if needed
            $this->currentEditingTemplate = $this->preview ? $this->replaceInputFieldsWithValues($newTemplate) : $newTemplate;

            // $this->dispatch('update-editor', ['currentEditingTemplate' => $this->currentEditingTemplate]);

            $this->successToast('Template reset successfully.');
        } catch (\Exception $e) {
            $this->errorToast('Failed to reset template.');
        }
    }

    private function replaceInputFieldsWithValues($template)
    {
        return preg_replace_callback('/<input[^>]*wire:model\.defer="placeholders\.([^"]+)"[^>]*>/', function ($matches) {
            $fieldName = $matches[1];
            $value = $this->placeholders[$fieldName] ?? '';

            // Return just the value as plain text
            return e($value ?: '________________');
        }, $template);
    }







    // private function getFormattedData(): array
    // {
    //     $processedData = [];

    //     foreach ($this->data as $formKey => $formData) {
    //         if (!isset($formData['fields'])) {
    //             continue;
    //         }

    //         foreach ($formData['fields'] as $fieldSlug => $fieldValue) {
    //             // Extract the actual field slug (remove form_1_ prefix)
    //             $fieldSlugParts = explode('_', $fieldSlug);
    //             $actualFieldSlug = end($fieldSlugParts); // This gives us 'abc-abc'

    //             $fieldDefinition = collect($formData['fields'])->firstWhere('slug', $fieldValue['slug'] ?? $fieldSlug);

    //             if ($fieldDefinition && $fieldDefinition['type'] === 'table') {
    //                 $tableData = [];

    //                 foreach ($fieldValue['fields'] as $index => $field) {
    //                     $processedRow = [];

    //                     foreach ($field as $rowKey => $rowValue) {
    //                         if (is_array($rowValue) && isset($rowValue['value']) && is_string($rowValue['value'])) {
    //                             // Convert value inside nested structure
    //                             $rowValue['value'] = replaceNumbers($rowValue['value'], true);
    //                             $processedRow[$rowKey] = $rowValue;
    //                         } else {
    //                             $processedRow[$rowKey] = $rowValue;
    //                         }
    //                     }

    //                     if (!empty($processedRow)) {
    //                         $tableData[] = $processedRow;
    //                     }
    //                 }

    //                 $processedData[$actualFieldSlug] = [
    //                     'label' => $fieldDefinition['label'] ?? '',
    //                     'slug' => $actualFieldSlug,
    //                     'type' => 'table',
    //                     'value' => $tableData
    //                 ];
    //             } elseif ($fieldDefinition['type'] === 'file' && is_array($fieldDefinition)) {
    //                 $storedDocuments = [];

    //                 if (isset($fieldDefinition['value'])) {
    //                     $document = $fieldDefinition['value'];

    //                     if (is_array($document)) {
    //                         foreach ($document as $file) {
    //                             if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
    //                                 $path = FileFacade::saveFile(
    //                                     config('src.BusinessRegistration.businessRegistration.registration'),
    //                                     "",
    //                                     $file,
    //                                     'local'
    //                                 );
    //                                 $storedDocuments[] = $path;
    //                             }
    //                         }
    //                     } else {
    //                         if ($document instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
    //                             $path = FileFacade::saveFile(
    //                                 config('src.BusinessRegistration.businessRegistration.registration'),
    //                                 "",
    //                                 $document,
    //                                 'local'
    //                             );
    //                             $storedDocuments[] = $path;
    //                         }
    //                     }
    //                 }

    //                 $processedData[$actualFieldSlug] = array_merge(
    //                     $fieldDefinition ?? [],
    //                     [
    //                         'label' => $fieldDefinition['label'] ?? '',
    //                         'value' => $storedDocuments,
    //                     ]
    //                 );
    //             } else {
    //                 $value = $fieldValue['value'] ?? null;

    //                 if (is_string($value)) {
    //                     $value = replaceNumbers($value, true);
    //                 }

    //                 $processedData[$actualFieldSlug] = array_merge($fieldDefinition ?? [], [
    //                     'value' => $value,
    //                     'label' => $fieldDefinition['label'] ?? '',
    //                 ]);
    //             }
    //         }
    //     }

    //     return $processedData;
    // }

    /**
     * Get resolved form data for template replacement
     * This converts the form data to the format needed for {{form.field}} replacement
     */
    // private function getResolvedFormData(): array
    // {
    //     $formattedData = $this->getFormattedData();

    //     return collect($formattedData)
    //         ->mapWithKeys(function ($data) {
    //             $slug = $data['slug'];

    //             if ($data['type'] === 'table') {
    //                 $tableHtml = generateTableHtml($data['fields'] ?? []);
    //                 return ["{{form.{$slug}}}" => $tableHtml];
    //             } elseif ($data['type'] === 'file') {
    //                 $fileHtml = getFiles($data['value'] ?? null);
    //                 return ["{{form.{$slug}}}" => $fileHtml];
    //             } else {
    //                 return ["{{form.{$slug}}}" => $data['value'] ?? ''];
    //             }
    //         })
    //         ->toArray();
    // }


    // public function setFields()
    // {
    //     try {
    //         $additionalForms = AdditionalForm::with('form')->where('status', true)->get();

    //         $this->data = [];

    //         foreach ($additionalForms as $additionalForm) {
    //             if (!$additionalForm->form) continue;

    //             $formFields = json_decode($additionalForm->form->fields, true);
    //             if (!$formFields) continue;

    //             $formKey = 'form_' . $additionalForm->id;
    //             $this->data[$formKey] = [
    //                 'form_name' => $additionalForm->name,
    //                 'form_id' => $additionalForm->id,
    //                 'fields' => []
    //             ];

    //             // Process fields with proper handling for table and group types
    //             $processedFields = collect($formFields)
    //                 ->filter(function ($field) {
    //                     return isset($field['type']);
    //                 })
    //                 ->map(function ($field) {
    //                     // Handle table fields
    //                     if ($field['type'] === "table") {
    //                         $field['fields'] = [];
    //                         $row = [];
    //                         foreach ($field as $key => $values) {
    //                             if (is_numeric($key)) {
    //                                 $row[$values['slug']] = $values;
    //                                 unset($field[$key]);
    //                             }
    //                         }
    //                         $field['fields'][] = $row;
    //                     }
    //                     // Handle group fields
    //                     elseif ($field['type'] === "group") {
    //                         $fields = [];
    //                         foreach ($field as $key => $values) {
    //                             if (is_numeric($key)) {
    //                                 $values['value'] = $this->initializeFieldValue($values);
    //                                 $fields[$values['slug']] = $values;
    //                                 unset($field[$key]);
    //                             }
    //                         }
    //                         $field['fields'] = $fields;
    //                     }
    //                     // Handle regular fields
    //                     else {
    //                         $field['value'] = $this->initializeFieldValue($field);
    //                     }

    //                     return $field;
    //                 })
    //                 ->toArray();

    //             // Add processed fields to data structure
    //             foreach ($processedFields as $field) {
    //                 if (!isset($field['slug'])) {
    //                     continue;
    //                 }

    //                 // Use the original slug for the field key, not the prefixed one
    //                 $this->data[$formKey]['fields'][$field['slug']] = $field;
    //             }
    //         }

    //         // Load existing data if editing
    //         $this->loadExistingDynamicData();
    //     } catch (\Exception $e) {
    //         $this->data = [];
    //     }
    // }

    /**
     * Initialize field value based on field type and default value
     */
    // private function initializeFieldValue($field)
    // {
    //     $type = $field['type'] ?? 'text';

    //     switch ($type) {
    //         case 'checkbox':
    //             // For multiple checkboxes, initialize as empty array
    //             if (($field['is_multiple'] ?? '0') === '1') {
    //                 return [];
    //             }
    //             // For single checkbox, use default value or false
    //             return $field['default_value'] ?? false;

    //         case 'select':
    //             // For multiple select, initialize as empty array
    //             if (($field['is_multiple'] ?? '0') === '1') {
    //                 return [];
    //             }
    //             // For single select, use default value or null
    //             return $field['default_value'] ?? null;

    //         case 'table':
    //             // Initialize table with empty array
    //             return [];

    //         case 'group':
    //             // Initialize group fields
    //             $groupFields = [];
    //             if (isset($field['fields'])) {
    //                 foreach ($field['fields'] as $groupField) {
    //                     $groupFields[$groupField['slug']] = $this->initializeFieldValue($groupField);
    //                 }
    //             }
    //             return $groupFields;

    //         default:
    //             // For text, textarea, radio, file, etc.
    //             return $field['default_value'] ?? null;
    //     }
    // }

    // private function loadExistingDynamicData()
    // {
    //     try {
    //         $existingData = AdditionalFormDynamicData::where('map_apply_id', $this->mapApply->id)->get();

    //         foreach ($existingData as $data) {
    //             $formKey = 'form_' . $data->additional_form_id;

    //             if (isset($this->data[$formKey]) && isset($data->form_data)) {
    //                 // Load the saved form data
    //                 foreach ($data->form_data as $fieldSlug => $fieldData) {
    //                     // Find the corresponding field in current form structure
    //                     if (isset($this->data[$formKey]['fields'][$fieldSlug])) {
    //                         $field = &$this->data[$formKey]['fields'][$fieldSlug];

    //                         // Handle different field types when loading existing data
    //                         if ($field['type'] === 'table') {
    //                             // Load table data - ensure we have the proper structure
    //                             if (isset($fieldData['value']) && is_array($fieldData['value'])) {
    //                                 $field['fields'] = $fieldData['value'];
    //                             } else {
    //                                 // Initialize with empty array if no data
    //                                 $field['fields'] = [];
    //                             }
    //                         } elseif ($field['type'] === 'group') {
    //                             // Load group data
    //                             if (isset($fieldData['value']) && is_array($fieldData['value'])) {
    //                                 foreach ($fieldData['value'] as $groupFieldSlug => $groupFieldValue) {
    //                                     if (isset($field['fields'][$groupFieldSlug])) {
    //                                         $field['fields'][$groupFieldSlug]['value'] = $groupFieldValue;
    //                                     }
    //                                 }
    //                             }
    //                         } else {
    //                             // Load regular field data
    //                             $field['value'] = $fieldData['value'] ?? null;
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     } catch (\Exception $e) {
    //         // Silently fail if there's an error loading existing data
    //     }
    // }




    // private function processDynamicFormData($mapApplyId)
    // {
    //     // Get formatted data from dynamic forms
    //     $formattedData = $this->getFormattedData();

    //     // Delete existing data for this map_apply_id
    //     AdditionalFormDynamicData::where('map_apply_id', $mapApplyId)->delete();

    //     // Group the formatted data by additional_form_id
    //     $groupedData = [];

    //     foreach ($this->data as $formKey => $formData) {
    //         if (!isset($formData['form_id']) || !isset($formData['fields'])) {
    //             continue;
    //         }

    //         $additionalFormId = $formData['form_id'];

    //         // Get the fields for this form from formatted data
    //         $formFields = [];
    //         foreach ($formattedData as $fieldSlug => $fieldData) {
    //             // Check if this field belongs to this form
    //             if (isset($formData['fields'][$fieldSlug])) {
    //                 $formFields[$fieldSlug] = $fieldData;
    //             }
    //         }

    //         if (!empty($formFields)) {
    //             $groupedData[$additionalFormId] = $formFields;
    //         }
    //     }

    //     // Save the grouped data
    //     foreach ($groupedData as $additionalFormId => $formFields) {
    //         try {
    //             AdditionalFormDynamicData::create([
    //                 'map_apply_id' => $mapApplyId,
    //                 'additional_form_id' => $additionalFormId,
    //                 'form_data' => $formFields
    //             ]);
    //         } catch (\Exception $e) {
    //             // Silently handle any save errors
    //         }
    //     }
    // }

    /**
     * Add a new row to a table field
     */
    // public function addTableRow($formKey, $fieldSlug)
    // {
    //     if (isset($this->data[$formKey]['fields'][$fieldSlug])) {
    //         $field = &$this->data[$formKey]['fields'][$fieldSlug];

    //         if ($field['type'] === 'table') {
    //             // Create a new row with the same structure as the first row
    //             if (!empty($field['fields'])) {
    //                 $newRow = [];
    //                 foreach ($field['fields'][0] as $columnSlug => $columnField) {
    //                     $newRow[$columnSlug] = [
    //                         'slug' => $columnField['slug'],
    //                         'label' => $columnField['label'],
    //                         'type' => $columnField['type'],
    //                         'value' => $this->initializeFieldValue($columnField)
    //                     ];
    //                 }
    //                 $field['fields'][] = $newRow;
    //             } else {
    //                 // If no existing rows, create the first row from the field structure
    //                 $newRow = [];
    //                 foreach ($field as $key => $values) {
    //                     if (is_numeric($key)) {
    //                         $newRow[$values['slug']] = [
    //                             'slug' => $values['slug'],
    //                             'label' => $values['label'],
    //                             'type' => $values['type'],
    //                             'value' => $this->initializeFieldValue($values)
    //                         ];
    //                     }
    //                 }
    //                 if (!empty($newRow)) {
    //                     $field['fields'][] = $newRow;
    //                 }
    //             }
    //         }
    //     }
    // }

    /**
     * Remove a row from a table field
     */
    // public function removeTableRow($formKey, $fieldSlug, $rowIndex)
    // {
    //     if (isset($this->data[$formKey]['fields'][$fieldSlug])) {
    //         $field = &$this->data[$formKey]['fields'][$fieldSlug];

    //         if ($field['type'] === 'table' && isset($field['fields'][$rowIndex])) {
    //             unset($field['fields'][$rowIndex]);
    //             // Reindex the array
    //             $field['fields'] = array_values($field['fields']);
    //         }
    //     }
    // }
}
