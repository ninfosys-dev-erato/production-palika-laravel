<?php

namespace Src\Ebps\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\BuildingCriterias\Controllers\BuildingCriteriaAdminController;
use Src\Ebps\DTO\BuildingCriteriaAdminDto;
use Src\Ebps\Models\BuildingCriteria;
use Src\Ebps\Service\BuildingCriteriaAdminService;
use Livewire\Attributes\On;

class BuildingCriteriaForm extends Component
{
    use SessionFlash;

    public ?BuildingCriteria $buildingCriteria;
    public ?Action $action = Action::CREATE;


    public bool $isActive=false;


    public $toogleStatus = true;

    public function rules(): array
    {
        return [
    'buildingCriteria.min_gcr' => ['required'],
    'buildingCriteria.min_far' => ['required'],
    'buildingCriteria.min_dist_center' => ['required'],
    'buildingCriteria.min_dist_side' => ['required'],
    'buildingCriteria.min_dist_right' => ['required'],
    'buildingCriteria.setback' => ['required'],
    'buildingCriteria.dist_between_wall_and_boundaries' => ['required'],
    'buildingCriteria.public_place_distance' => ['required'],
    'buildingCriteria.cantilever_distance' => ['required'],
    'buildingCriteria.high_tension_distance' => ['required'],
    'buildingCriteria.is_active' => ['nullable'],
];
    }

    public function render(){
        return view("Ebps::livewire.building-criterias.building-criterias-form");
    }
    public function mount(BuildingCriteria $buildingCriteria, Action $action)
    {
        $this->buildingCriteria = $buildingCriteria;
        $this->action = $action;
        $this->isActive = $buildingCriteria->exists() && $buildingCriteria->is_active !== null
            ? (bool) $buildingCriteria->is_active
            : false;
    }

    public function save()
    {
        $this->validate();
        try{
            $this->buildingCriteria->is_active = $this->isActive;
            $dto = BuildingCriteriaAdminDto::fromLiveWireModel($this->buildingCriteria);
            $service = new BuildingCriteriaAdminService();
            switch ($this->action){
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ebps::ebps.building_criteria_created_successfully'));
                    // return redirect()->route('admin.ebps.building_criterias.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();

                    break;
                case Action::UPDATE:
                    $service->update($this->buildingCriteria,$dto);
                    $this->successFlash(__('ebps::ebps.building_criteria_updated_successfully'));
                    // return redirect()->route('admin.ebps.building_criterias.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();

                    break;
                default:
                    return redirect()->route('admin.ebps.building_criterias.index');
                    break;
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash(((__('ebps::ebps.something_went_wrong_while_saving') . $e->getMessage())));
        }
    }

    #[On('edit-Building-Criteria')]
    public function editBuildingCriteria(BuildingCriteria $buildingCriteria)
    {
        $this->buildingCriteria = $buildingCriteria;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['buildingCriteria', 'action']);
        $this->buildingCriteria = new BuildingCriteria();
    }
    #[On('reset-form')]
    public function resetBuildingCriteria()
    {
        $this->resetForm();
    }
}
