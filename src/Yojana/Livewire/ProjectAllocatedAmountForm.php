<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\ProjectAllocatedAmountAdminDto;
use Src\Yojana\Models\ProjectAllocatedAmount;
use Src\Yojana\Service\ProjectAllocatedAmountAdminService;

class ProjectAllocatedAmountForm extends Component
{
    use SessionFlash;

    public ?ProjectAllocatedAmount $projectAllocatedAmount;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'projectAllocatedAmount.project_id' => ['required'],
    'projectAllocatedAmount.budget_head_id' => ['required'],
    'projectAllocatedAmount.amount' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'projectAllocatedAmount.project_id.required' => __('yojana::yojana.project_id_is_required'),
            'projectAllocatedAmount.budget_head_id.required' => __('yojana::yojana.budget_head_id_is_required'),
            'projectAllocatedAmount.amount.required' => __('yojana::yojana.amount_is_required'),
        ];
    }

    public function render(){
        return view("ProjectAllocatedAmounts::livewire.form");
    }

    public function mount(ProjectAllocatedAmount $projectAllocatedAmount,Action $action)
    {
        $this->projectAllocatedAmount = $projectAllocatedAmount;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = ProjectAllocatedAmountAdminDto::fromLiveWireModel($this->projectAllocatedAmount);
        $service = new ProjectAllocatedAmountAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Project Allocated Amount Created Successfully");
                return redirect()->route('admin.project_allocated_amounts.index');
                break;
            case Action::UPDATE:
                $service->update($this->projectAllocatedAmount,$dto);
                $this->successFlash("Project Allocated Amount Updated Successfully");
                return redirect()->route('admin.project_allocated_amounts.index');
                break;
            default:
                return redirect()->route('admin.project_allocated_amounts.index');
                break;
        }
    }
}
