<?php

namespace Src\TaskTracking\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\TaskTracking\DTO\EmployeeMarkingScoreAdminDto;
use Src\TaskTracking\Models\EmployeeMarkingScore;
use Src\TaskTracking\Service\EmployeeMarkingScoreAdminService;

class EmployeeMarkingScoreForm extends Component
{
    use SessionFlash;

    public ?EmployeeMarkingScore $employeeMarkingScore;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'employeeMarkingScore.employee_marking_id' => ['required'],
    'employeeMarkingScore.criteria_id' => ['required'],
    'employeeMarkingScore.score_obtained' => ['required'],
    'employeeMarkingScore.score_out_of' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'employeeMarkingScore.employee_marking_id.required' => __('tasktracking::tasktracking.employee_marking_id_is_required'),
            'employeeMarkingScore.criteria_id.required' => __('tasktracking::tasktracking.criteria_id_is_required'),
            'employeeMarkingScore.score_obtained.required' => __('tasktracking::tasktracking.score_obtained_is_required'),
            'employeeMarkingScore.score_out_of.required' => __('tasktracking::tasktracking.score_out_of_is_required'),
        ];
    }

    public function render(){
        return view("TaskTracking::livewire.employee-marking-score-form");
    }

    public function mount(EmployeeMarkingScore $employeeMarkingScore,Action $action)
    {
        $this->employeeMarkingScore = $employeeMarkingScore;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = EmployeeMarkingScoreAdminDto::fromLiveWireModel($this->employeeMarkingScore);
            $service = new EmployeeMarkingScoreAdminService();
            switch ($this->action){
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('tasktracking::tasktracking.employee_marking_score_created_successfully'));
                    return redirect()->route('admin.employee_marking_scores.index');
                case Action::UPDATE:
                    $service->update($this->employeeMarkingScore,$dto);
                    $this->successFlash(__('tasktracking::tasktracking.employee_marking_score_updated_successfully'));
                    return redirect()->route('admin.employee_marking_scores.index');
                default:
                    return redirect()->route('admin.employee_marking_scores.index');
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash(((__('tasktracking::tasktracking.something_went_wrong_while_saving') . $e->getMessage())));
        }
    }
}
