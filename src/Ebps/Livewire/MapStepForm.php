<?php

namespace Src\Ebps\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Src\Ebps\Enums\ApplicationTypeEnum;
use Src\Ebps\Models\ConstructionType;
use Src\Ebps\Models\ConstructionTypeMapStep;
use Src\Ebps\Models\FormMapStep;
use Src\Ebps\Models\MapPassGroup;
use Src\Ebps\Models\MapPassGroupMapStep;
use Src\MapSteps\Controllers\MapStepAdminController;
use Src\Ebps\DTO\MapStepAdminDto;
use Src\Ebps\Models\MapStep;
use Src\Ebps\Service\MapStepAdminService;
use Src\Settings\Models\Form;

class MapStepForm extends Component
{
    use SessionFlash;

    public ?MapStep $mapStep;
    public ?Action $action;
    public bool $canSkip = false;
    public bool $isPublic = false;
    public bool $isPalika = false;
    public bool $isConsultant = false;
    public bool $isHouseOwner = false;
    public array $mapPassGroup = [];
    public array $forms = [];
    public array $constructionTypes = [];
    public array $approverSelects = [];
    public array $approverPosition = [];
    public array $formSelects = [];
    public array $constructionTypeSelects = [];
    public array $constructionTypePosition = [];
    public ?string $submitter = null;
    public $submitter_position = 0;
    public $applicationTypes;

    public function rules(): array
    {
        $rules = [
            'mapStep.title' => ['required'],
            'mapStep.form_submitter' => ['nullable'],
            'mapStep.form_position' => ['nullable'],
            'mapStep.step_for' => ['required'],
            'mapStep.application_type' => ['required'],
            'approverSelects' => ['array'],
            'approverPosition' => ['nullable'],
            'constructionTypeSelects' => ['array'],
            'approverPosition.*' => ['nullable'],
            'constructionTypePosition.*' => ['nullable'],
            'submitter' => ['nullable'],
            'submitter_position' => ['nullable'],
        ];

        if ($this->isConsultant) {
            $rules['submitter'] = ['nullable'];
            $rules['submitter_position'] = ['nullable'];
        } else {
            $rules['submitter'] = ['nullable'];
            $rules['submitter_position'] = ['nullable'];
        }

        return $rules;
    }

    public function render(){
        return view("Ebps::livewire.map-step.map-step-form");
    }

    public function mount(MapStep $mapStep, Action $action)
    {
        $this->mapStep = $mapStep;
        $this->action = $action;
        $this->mapPassGroup = MapPassGroup::whereNull('deleted_at')->get()->toArray();
        $this->forms = Form::whereNull('deleted_at')->where('module', 'Ebps')->get()->toArray();
        $this->constructionTypes = ConstructionType::whereNull('deleted_at')->get()->toArray();
        $this->applicationTypes = ApplicationTypeEnum::cases();

        if ($action === Action::UPDATE) {
            $this->loadConstructionData($mapStep);
            $this->loadFormData($mapStep);
            $this->loadApproverData($mapStep);
            $this->loadSubmitterData($mapStep);

            $this->isPublic = $mapStep->is_public;
            $this->canSkip = $mapStep->can_skip;
        }
    }

    private function loadConstructionData(MapStep $mapStep)
    {
        $construction = ConstructionTypeMapStep::where('map_step_id', $mapStep->id)
            ->get()
            ->groupBy('construction_type_id');

        foreach ($construction as $constructionId => $constructionRecords) {
            $this->constructionTypeSelects[] = $constructionId;
            $this->constructionTypePosition[] = $constructionRecords->pluck('position')->toArray();
        }
    }

    private function loadFormData(MapStep $mapStep)
    {
        $form = FormMapStep::where('map_step_id', $mapStep->id)->get();
        $this->formSelects = $form->pluck('form_id')->toArray();
    }

    private function loadApproverData(MapStep $mapStep)
    {
        $approver = MapPassGroupMapStep::where('map_step_id', $mapStep->id)
            ->where('type', 'approver')
            ->get()
            ->groupBy('map_pass_group_id');

        foreach ($approver as $approverId => $approverRecords) {
            $this->approverSelects[] = $approverId;
            $this->approverPosition[] = $approverRecords->pluck('position')->toArray();
        }
    }

    private function loadSubmitterData(MapStep $mapStep)
    {
        $submitter = MapPassGroupMapStep::where('map_step_id', $mapStep->id)
            ->where('type', 'submitter')
            ->get()
            ->groupBy('map_pass_group_id');

        if ($submitter->isEmpty()) {
            $this->isConsultant = true;
        } else {
            foreach ($submitter as $submitterId => $submitterRecords) {
                $this->submitter = $submitterId;
                $this->submitter_position = $submitterRecords->pluck('position')->toArray();
            }
        }
    }

    public function checkFormSubmitter()
    {
        if ($this->mapStep->form_submitter === 'house_owner' || $this->mapStep->form_submitter === 'consultant_supervisor') {
            $this->isConsultant = true;
        } else {
            $this->isConsultant = false;
        }
    }

    public function addApprover()
    {
        $this->approverSelects[] = '';
        $index = array_key_last($this->approverSelects);
    }

    public function removeApprover($index)
    {
        unset($this->approverSelects[$index]);
        $this->approverSelects = array_values($this->approverSelects);
    }

    public function addForm()
    {
        $this->formSelects[] = '';
        $index = array_key_last($this->formSelects);
    }

    public function removeForm($index)
    {
        unset($this->formSelects[$index]);
        $this->formSelects = array_values($this->formSelects);
    }

    public function addConstructionType()
    {
        $this->constructionTypeSelects[] = '';
        $index = array_key_last($this->constructionTypeSelects);
    }

    public function removeConstructionType($index)
    {
        unset($this->constructionTypeSelects[$index]);
        $this->constructionTypeSelects = array_values($this->constructionTypeSelects);
    }

    public function save()
    {
        try {
            // Define your validation rules
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Catch validation exceptions and dd the errors
            dd($e->errors()); // Returns an array of validation error messages
        } catch (\Exception $e) {
            // Catch any other exceptions and dd the message
            dd($e->getMessage());
        }

        $this->mapStep->can_skip = $this->canSkip;
        $this->mapStep->is_public = $this->isPublic;
        $dto = MapStepAdminDto::fromLiveWireModel($this->mapStep);
        $service = new MapStepAdminService();
        
        DB::beginTransaction();
        try {
            switch ($this->action) {
                case Action::CREATE:
                    $this->createMapStep($service, $dto);
                    DB::commit();
                    $this->successFlash(__('ebps::ebps.map_step_created_successfully'));
                    return redirect()->route('admin.ebps.map_steps.index');
                    break;
                case Action::UPDATE:
                    $this->updateMapStep($service, $dto);
                    DB::commit();
                    $this->successFlash(__('ebps::ebps.map_step_updated_successfully'));
                    return redirect()->route('admin.ebps.map_steps.index');
                    break;
                default:
                    return redirect()->route('admin.ebps.map_steps.index');
                    break;
            }
        } catch (\Exception $e) {
            logger($e);
            dd($e);
            DB::rollBack();
            $this->errorFlash(__('ebps::ebps.an_error_occurred_during_operation_please_try_again_later'));
        }
    }

    private function createMapStep($service, $dto)
    {
        $mapStep = $service->store($dto);
        $this->syncRelations($mapStep);
        $this->successFlash(__('ebps::ebps.map_step_created_successfully'));
    }

    private function updateMapStep($service, $dto)
    {
        // Remove old group assignments
        $this->mapStep->mapPassGroupMapSteps()->delete();
        
        // Remove old construction type and form assignments
        $this->mapStep->constructionTypes()->detach();
        $this->mapStep->form()->detach();

        $service->update($this->mapStep, $dto);
        $this->syncRelations($this->mapStep);
        $this->successFlash(__('ebps::ebps.map_step_updated_successfully'));
    }

    private function syncRelations($mapStep)
    {
        // Sync forms
        $mapStep->form()->sync($this->formSelects);

        // Sync construction types
        $mapStep->constructionTypes()->sync($this->prepareConstructionData());
        
        // Sync group assignments using the new group-based system
        $this->syncGroupAssignments($mapStep);
    }

    private function syncGroupAssignments($mapStep)
    {
        // Clear existing group assignments
        $mapStep->mapPassGroupMapSteps()->delete();

        // Add approver groups
        foreach ($this->approverSelects as $index => $groupId) {
            if ($groupId && !empty($groupId)) {
                // Get the position value - handle both array and single value cases
                $position = $index + 1; // Default position
                if (isset($this->approverPosition[$index])) {
                    if (is_array($this->approverPosition[$index])) {
                        // If it's an array, take the first value
                        $position = $this->approverPosition[$index][0] ?? ($index + 1);
                    } else {
                        // If it's a single value
                        $position = $this->approverPosition[$index];
                    }
                }
                
                MapPassGroupMapStep::create([
                    'map_step_id' => $mapStep->id,
                    'map_pass_group_id' => $groupId,
                    'type' => 'approver',
                    'position' => (int) $position,
                ]);
            }
        }

        // Add submitter group (only one allowed)
        if ($this->submitter && !empty($this->submitter)) {
            // Get the position value for submitter - handle both array and single value cases
            $position = 1; // Default position
            if (isset($this->submitter_position)) {
                if (is_array($this->submitter_position)) {
                    // If it's an array, take the first value
                    $position = $this->submitter_position[0] ?? 1;
                } else {
                    // If it's a single value
                    $position = $this->submitter_position;
                }
            }
            
            MapPassGroupMapStep::create([
                'map_step_id' => $mapStep->id,
                'map_pass_group_id' => $this->submitter,
                'type' => 'submitter',
                'position' => (int) $position,
            ]);
        }
    }

    private function prepareConstructionData()
    {
        $constructionData = [];
        foreach ($this->constructionTypeSelects as $index => $constructionTypeId) {
            if ($constructionTypeId && !empty($constructionTypeId)) {
                // Get the position value - handle both array and single value cases
                $position = 0;
                if (isset($this->constructionTypePosition[$index])) {
                    if (is_array($this->constructionTypePosition[$index])) {
                        // If it's an array, take the first value
                        $position = $this->constructionTypePosition[$index][0] ?? 0;
                    } else {
                        // If it's a single value
                        $position = $this->constructionTypePosition[$index];
                    }
                }
                
                $constructionData[$constructionTypeId] = ['position' => (int) $position];
            }
        }
        return $constructionData;
    }
}
