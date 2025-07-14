<?php

namespace Src\Ebps\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\BuildingConstructionTypes\Controllers\BuildingConstructionTypeAdminController;
use Src\Ebps\DTO\BuildingConstructionTypeAdminDto;
use Src\Ebps\Models\BuildingConstructionType;
use Src\Ebps\Service\BuildingConstructionTypeAdminService;
use Livewire\Attributes\On;

class BuildingConstructionTypeForm extends Component
{
    use SessionFlash;

    public ?BuildingConstructionType $buildingConstructionType;
    public ?Action $action = Action::CREATE;

    public function rules(): array
    {
        return [
            'buildingConstructionType.title' => ['required'],
        ];
    }

    public function render()
    {
        return view("Ebps::livewire.building-construction-type.building-construction-type-form");
    }

    public function mount(BuildingConstructionType $buildingConstructionType, Action $action)
    {
        $this->buildingConstructionType = $buildingConstructionType;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = BuildingConstructionTypeAdminDto::fromLiveWireModel($this->buildingConstructionType);
            $service = new BuildingConstructionTypeAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ebps::ebps.building_construction_type_created_successfully'));
                    // return redirect()->route('admin.ebps.building_construction_types.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                case Action::UPDATE:
                    $service->update($this->buildingConstructionType, $dto);
                    $this->successFlash(__('ebps::ebps.building_construction_type_updated_successfully'));
                    // return redirect()->route('admin.ebps.building_construction_types.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                default:
                    return redirect()->route('admin.ebps.building_construction_types.index');
                    break;
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash(((__('ebps::ebps.something_went_wrong_while_saving') . $e->getMessage())));
        }
    }

    #[On('edit-construction-type')]
    public function editBuildingConstructionType(BuildingConstructionType $buildingConstructionType)
    {
        $this->buildingConstructionType = $buildingConstructionType;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['buildingConstructionType', 'action']);
        $this->buildingConstructionType = new BuildingConstructionType();
    }
    #[On('reset-form')]
    public function resetBuildingConstructionType()
    {
        $this->resetForm();
    }
}
