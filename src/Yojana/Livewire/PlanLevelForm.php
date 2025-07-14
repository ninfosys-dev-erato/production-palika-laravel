<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\Yojana\DTO\PlanLevelAdminDto;
use Src\Yojana\Models\PlanLevel;
use Src\Yojana\Models\Unit;
use Src\Yojana\Service\PlanLevelAdminService;

class PlanLevelForm extends Component
{
    use SessionFlash;

    public ?PlanLevel $planLevel;
    public ?Action $action = Action::CREATE;

    public function rules(): array
    {
        return [
            'planLevel.level_name' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'planLevel.level_name.required' => __('yojana::yojana.the_plan_level_is_required')
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.plan-levels.form");
    }

    public function mount(PlanLevel $planLevel, Action $action)
    {
        $this->planLevel = $planLevel;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = PlanLevelAdminDto::fromLiveWireModel($this->planLevel);
        $service = new PlanLevelAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successToast(__('yojana::yojana.plan_level_created_successfully'));
//                return redirect()->route('admin.plan_levels.index');
                $this->resetForm();
                break;
            case Action::UPDATE:
                $service->update($this->planLevel, $dto);
                $this->successToast(__('yojana::yojana.plan_level_updated_successfully'));
//                return redirect()->route('admin.plan_levels.index');
                $this->resetForm();
                break;
            default:
                return redirect()->route('admin.plan_levels.index');
                break;
        }
        $this->dispatch('close-modal');
    }
    #[On('edit-plan-level')]
    public function editPlanLevel(PlanLevel $planLevel){
        $this->planLevel = $planLevel;
        $this->action = Action::UPDATE;
        $this->isSmallest = $this->planLevel->is_smallest;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['planLevel', 'action']);
        $this->planLevel = new PlanLevel();
    }
    #[On('reset-form')]
    public function resetPlanLevel()
    {
        $this->resetForm();
    }
}
