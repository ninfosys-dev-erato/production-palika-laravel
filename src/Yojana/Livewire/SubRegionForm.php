<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\SubRegionAdminDto;
use Src\Yojana\Models\PlanArea;
use Src\Yojana\Models\SubRegion;
use Src\Yojana\Service\SubRegionAdminService;
use Livewire\Attributes\On;

class SubRegionForm extends Component
{
    use SessionFlash;

    public ?SubRegion $subRegion;
    public ?Action $action = Action::CREATE;
    public $planAreas;

    public function rules(): array
    {
        return [
            'subRegion.name' => ['required'],
            'subRegion.code' => ['required'],
            'subRegion.area_id' => ['required'],
            'subRegion.in_use' => ['nullable'],
        ];
    }
    public function messages(): array
    {
        return [
            'subRegion.name.required' => __('yojana::yojana.name_is_required'),
            'subRegion.code.required' => __('yojana::yojana.code_is_required'),
            'subRegion.area_id.required' => __('yojana::yojana.area_id_is_required'),
            'subRegion.in_use.nullable' => __('yojana::yojana.in_use_is_optional'),
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.sub-regions.form");
    }

    public function mount(SubRegion $subRegion, Action $action)
    {
        $this->planAreas = PlanArea::pluck('area_name', 'id');
        $this->subRegion = $subRegion;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = SubRegionAdminDto::fromLiveWireModel($this->subRegion);
        $service = new SubRegionAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.sub_region_created_successfully'));
                $this->dispatch('close-modal');
//                return redirect()->route('admin.sub_regions.index');
                break;
            case Action::UPDATE:
                $service->update($this->subRegion, $dto);
                $this->successFlash(__('yojana::yojana.sub_region_updated_successfully'));
                $this->dispatch('close-modal');
//                return redirect()->route('admin.sub_regions.index');
                break;
            default:
                return redirect()->route('admin.sub_regions.index');
                break;
        }
    }


    #[On('edit-subRegion')]
    public function editSubRegion(SubRegion $subRegion)
    {
        $this->subRegion = $subRegion;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    #[On('reset-form')]
    public function resetConfiguration()
    {
        $this->reset(['subRegion', 'action']);
        $this->subRegion = new SubRegion();
    }
}
