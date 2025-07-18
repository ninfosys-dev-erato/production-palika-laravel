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
    public $reviewer;
    public  $reviewer_position;
    public ?string $submitter = null;

    public  $submitter_position = 0;

    public $applicationTypes ;

    public function rules(): array
    {
        $rules = [
            'mapStep.title' => ['required'],
            'mapStep.form_submitter' => ['nullable'],
            'mapStep.form_position' => ['nullable'],
            'mapStep.step_for' => ['required'],
            'mapStep.application_type' => ['required'],
            'approverSelects' => ['array'],
            'approverPosition' => ['array'],
            'constructionTypeSelects' => ['array'],
            'approverPosition.*' => ['numeric'],
            'constructionTypePosition.*' => ['numeric'],
            'reviewer' => ['nullable'],
            'reviewer_position' => ['nullable', 'numeric'],
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
            $this->loadReviwerData($mapStep);
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
    private function loadReviwerData(MapStep $mapStep)
    {
        $reviewer = MapPassGroupMapStep::where('map_step_id', $mapStep->id)
            ->where('type', 'reviewer')
            ->get()
            ->groupBy('map_pass_group_id');

            foreach ($reviewer as $reviewerId => $reviewerRecords) {

                $this->reviewer = $reviewerId;
                $this->reviewer_position = $reviewerRecords->pluck('position')->toArray();
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
        $this->validate();

        $this->mapStep->can_skip = $this->canSkip;
        $this->mapStep->is_public = $this->isPublic;
        $dto = MapStepAdminDto::fromLiveWireModel($this->mapStep);
        $service = new MapStepAdminService();
        DB::beginTransaction();
        try{
            switch ($this->action){
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
        $this->mapStep->users()->detach();
        $this->mapStep->constructionTypes()->detach();
        $this->mapStep->form()->detach();

        $service->update($this->mapStep, $dto);
        $this->syncRelations($this->mapStep);
        $this->successFlash(__('ebps::ebps.map_step_updated_successfully'));
    }

    private function syncRelations($mapStep)
    {
        $mapStep->form()->sync($this->formSelects);

        $mapStep->constructionTypes()->sync($this->prepareConstructionData());
        $mapStep->users()->sync($this->prepareApproverData());

        if ($this->reviewer) {
            $mapStep->users()->syncWithoutDetaching([
                $this->reviewer => [
                    'position' => $this->reviewer_position ?? 0,
                    'type' => 'reviewer'
                ]
            ]);
        }

        if ($this->submitter) {
            $mapStep->users()->syncWithoutDetaching([
                $this->submitter => [
                    'position' => $this->submitter_position ?? 0,
                    'type' => 'submitter'
                ]
            ]);
        }
    }

    private function prepareConstructionData()
    {
        $constructionData = [];
        foreach ($this->constructionTypeSelects as $index => $constructionTypeId) {
            $constructionData[$constructionTypeId] = ['position' => $this->constructionTypePosition[$index] ?? 0];
        }
        return $constructionData;
    }

    private function prepareApproverData()
    {
        $approverData = [];
        foreach ($this->approverSelects as $index => $approverId) {
            $approverData[$approverId] = [
                'position' => $this->approverPosition[$index] ?? 0,
                'type' => 'approver'
            ];
        }
        return $approverData;
    }
}
