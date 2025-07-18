<?php

namespace Src\TaskTracking\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\TaskTracking\DTO\EmployeeMarkingAdminDto;
use Src\TaskTracking\Models\EmployeeMarking;
use Src\TaskTracking\Service\EmployeeMarkingAdminService;

class EmployeeMarkingForm extends Component
{
    use SessionFlash;

    public ?EmployeeMarking $employeeMarking;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'employeeMarking.employee_id' => ['required'],
    'employeeMarking.anusuchi_id' => ['required'],
    'employeeMarking.score' => ['required'],
    'employeeMarking.fiscal_year' => ['required'],
    'employeeMarking.period_title' => ['required'],
    'employeeMarking.period_type' => ['required'],
    'employeeMarking.date_from' => ['required'],
    'employeeMarking.date_to' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'employeeMarking.employee_id.required' => __('tasktracking::tasktracking.employee_id_is_required'),
            'employeeMarking.anusuchi_id.required' => __('tasktracking::tasktracking.anusuchi_id_is_required'),
            'employeeMarking.score.required' => __('tasktracking::tasktracking.score_is_required'),
            'employeeMarking.fiscal_year.required' => __('tasktracking::tasktracking.fiscal_year_is_required'),
            'employeeMarking.period_title.required' => __('tasktracking::tasktracking.period_title_is_required'),
            'employeeMarking.period_type.required' => __('tasktracking::tasktracking.period_type_is_required'),
            'employeeMarking.date_from.required' => __('tasktracking::tasktracking.date_from_is_required'),
            'employeeMarking.date_to.required' => __('tasktracking::tasktracking.date_to_is_required'),
        ];
    }

    public function render(){
        return view("TaskTracking::livewire.employee-marking-form");
    }

    public function mount(EmployeeMarking $employeeMarking,Action $action)
    {
        $this->employeeMarking = $employeeMarking;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = EmployeeMarkingAdminDto::fromLiveWireModel($this->employeeMarking);
            $service = new EmployeeMarkingAdminService();
            switch ($this->action){
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('tasktracking::tasktracking.employee_marking_created_successfully'));
                    return redirect()->route('admin.employee_markings.index');
                case Action::UPDATE:
                    $service->update($this->employeeMarking,$dto);
                    $this->successFlash(__('tasktracking::tasktracking.employee_marking_updated_successfully'));
                    return redirect()->route('admin.employee_markings.index');
                default:
                    return redirect()->route('admin.employee_markings.index');
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash(((__('tasktracking::tasktracking.something_went_wrong_while_saving') . $e->getMessage())));
        }
    }
}
