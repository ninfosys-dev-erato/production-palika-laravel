<?php

namespace Src\Ebps\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\BuildingRoofTypes\Controllers\BuildingRoofTypeAdminController;
use Src\Ebps\DTO\BuildingRoofTypeAdminDto;
use Src\Ebps\Models\BuildingRoofType;
use Src\Ebps\Service\BuildingRoofTypeAdminService;
use Livewire\Attributes\On;

class BuildingRoofTypeForm extends Component
{
    use SessionFlash;

    public ?BuildingRoofType $buildingRoofType;
    public ?Action $action = Action::CREATE;


    public function rules(): array
    {
        return [
    'buildingRoofType.title' => ['required'],
];
    }

    public function render(){
        return view("Ebps::livewire.building-roof-type.building-roof-type-form");
    }

    public function mount(BuildingRoofType $buildingRoofType,Action $action)
    {
        $this->buildingRoofType = $buildingRoofType;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = BuildingRoofTypeAdminDto::fromLiveWireModel($this->buildingRoofType);
            $service = new BuildingRoofTypeAdminService();
            switch ($this->action){
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ebps::ebps.building_roof_type_created_successfully'));
                    // return redirect()->route('admin.ebps.building_roof_types.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                case Action::UPDATE:
                    $service->update($this->buildingRoofType,$dto);
                    $this->successFlash(__('ebps::ebps.building_roof_type_updated_successfully'));
                    // return redirect()->route('admin.ebps.building_roof_types.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                default:
                    return redirect()->route('admin.ebps.building_roof_types.index');
                    break;
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash(((__('ebps::ebps.something_went_wrong_while_saving') . $e->getMessage())));
        }
    }


    #[On('edit-building-roof-type')]
    public function editBuildingRoofType(BuildingRoofType $buildingRoofType)
    {
        $this->buildingRoofType = $buildingRoofType;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['buildingRoofType', 'action']);
        $this->buildingRoofType = new BuildingRoofType();
    }
    #[On('reset-form')]
    public function resetBuildingRoofType()
    {
        $this->resetForm();
    }
}
