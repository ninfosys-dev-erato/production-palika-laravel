<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\Yojana\DTO\PlanAreaAdminDto;
use Src\Yojana\Models\PlanArea;
use Src\Yojana\Models\Unit;
use Src\Yojana\Service\PlanAreaAdminService;

class PlanAreaForm extends Component
{
    use SessionFlash;

    public ?PlanArea $planArea;
    public ?Action $action = Action::CREATE;

    public function rules(): array
    {
        return [
            'planArea.area_name' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'planArea.area_name.required' => __('yojana::yojana.area_name_is_required'),
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.plan-areas.form");
    }

    public function mount(PlanArea $planArea, Action $action)
    {
        $this->planArea = $planArea;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = PlanAreaAdminDto::fromLiveWireModel($this->planArea);
        $service = new PlanAreaAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successToast(__('yojana::yojana.plan_area_created_successfully'));
                //                return redirect()->route('admin.plan_areas.index');
                $this->resetForm();

                break;
            case Action::UPDATE:
                $service->update($this->planArea, $dto);
                $this->successToast(__('yojana::yojana.plan_area_updated_successfully'));
                //                return redirect()->route('admin.plan_areas.index');
                $this->resetForm();
                break;
            default:
                return redirect()->route('admin.plan_areas.index');
                break;
        }
        $this->dispatch('close-modal');
    }
    #[On('edit-plan-area')]
    public function editPlanArea(PlanArea $planArea)
    {
        $this->planArea = $planArea;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['planArea', 'action']);
        $this->planArea = new PlanArea();
    }
    #[On('reset-form')]
    public function resetPlanArea()
    {
        $this->resetForm();
    }

}
