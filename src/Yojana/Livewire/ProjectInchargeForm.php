<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\Employees\Models\Employee;
use Src\Yojana\Controllers\ProjectInchargeAdminController;
use Src\Yojana\DTO\ProjectInchargeAdminDto;
use Src\Yojana\Enums\PlanStatus;
use Src\Yojana\Models\ItemType;
use Src\Yojana\Models\Plan;
use Src\Yojana\Models\ProjectIncharge;
use Src\Yojana\Models\Unit;
use Src\Yojana\Service\ProjectInchargeAdminService;

class ProjectInchargeForm extends Component
{
    use SessionFlash;

    public ?ProjectIncharge $projectIncharge;
    public ?Action $action = Action::CREATE;
    public $employees;
    public ?plan  $plan;
    public bool $is_active = true;

    public function rules(): array
    {
        return [
            'projectIncharge.employee_id' => ['required'],
            'projectIncharge.remarks' => ['nullable'],
            'projectIncharge.plan_id' => ['required'],
            'projectIncharge.is_active' => ['nullable'],
];
    }
    public function messages(): array
    {
        return [
            'projectIncharge.employee_id.required' => __('yojana::yojana.employee_id_is_required'),
            'projectIncharge.remarks.required' => __('yojana::yojana.remarks_is_required'),
            'projectIncharge.plan_id.required' => __('yojana::yojana.plan_id_is_required'),
            'projectIncharge.is_active.nullable' => __('yojana::yojana.is_active_is_optional'),
        ];
    }

    public function render(){
        return view("Yojana::livewire.project-incharge.form");
    }

    public function mount(ProjectIncharge $projectIncharge,Action $action)
    {
        $this->projectIncharge = $projectIncharge;
        $this->projectIncharge->is_active = true;
        $this->employees  = Employee::whereNull('deleted_at')->get();
        $this->action = $action;
    }

    public function save()
    {
        $this->projectIncharge->plan_id = $this->plan->id;
        $this->validate();
        try {
        $dto = ProjectInchargeAdminDto::fromLiveWireModel($this->projectIncharge);
        $service = new ProjectInchargeAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                if ($this->plan->status == PlanStatus::PlanEntry){
                    $this->plan->status = PlanStatus::ProjectInchargeAppointed;
                    $this->plan->save();
                    $this->dispatch('planStatusUpdate');
                }
                $this->successFlash(__('yojana::yojana.success_project_incharge_add'));
                break;
            case Action::UPDATE:
                $service->update($this->projectIncharge,$dto);
                $this->successFlash(__('yojana::yojana.success_project_incharge_update'));
                break;
            default:
                return redirect()->route('admin.project_incharge.index');
                break;
        }
            $this->dispatch('close-modal', id: 'projectInchargeModal');
        } catch (ValidationException $e) {
DB::rollBack();
//            dd($e->errors());
$this->errorFlash(collect($e->errors())->flatten()->first());

} catch (\Exception $e) {
    DB::rollBack();
//            dd($e->getMessage());
    $this->errorFlash(collect($e)->flatten()->first());

}
    }

    #[On('edit-project-incharge')]
    public function editProjectIncharge(ProjectIncharge $projectIncharge){
        $this->projectIncharge = $projectIncharge;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal', id: 'projectInchargeModal');

    }
    #[On('reset-form')]
    public function resetProjectIncharge()
    {
        $this->reset(['projectIncharge', 'action']);
        $this->projectIncharge = new ProjectIncharge();
        $this->projectIncharge->is_active = true;
    }

}

