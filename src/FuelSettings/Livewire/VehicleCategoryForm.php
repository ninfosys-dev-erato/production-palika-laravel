<?php

namespace Src\FuelSettings\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\FuelSettings\DTO\VehicleCategoryAdminDto;
use Src\FuelSettings\Models\VehicleCategory;
use Src\FuelSettings\Service\VehicleCategoryAdminService;
use Src\Yojana\Models\Unit;

class VehicleCategoryForm extends Component
{
    use SessionFlash;

    public ?VehicleCategory $vehicleCategory;
    public ?Action $action;

    public function rules(): array
    {
        return [
            'vehicleCategory.title' => ['required'],
            'vehicleCategory.title_en' => ['required'],
        ];
    }

    public function render()
    {
        return view("FuelSettings::livewire.vehicle-category-form");
    }

    public function mount(VehicleCategory $vehicleCategory, Action $action)
    {
        $this->vehicleCategory = $vehicleCategory;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = VehicleCategoryAdminDto::fromLiveWireModel($this->vehicleCategory);
            $service = new VehicleCategoryAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash("Vehicle Category Created Successfully");
//                    return redirect()->route('admin.vehicle_categories.index');
                    break;
                case Action::UPDATE:
                    $service->update($this->vehicleCategory, $dto);
                    $this->successFlash("Vehicle Category Updated Successfully");
//                    return redirect()->route('admin.vehicle_categories.index');
                    break;
                default:
                    return redirect()->route('admin.vehicle_categories.index');
                    break;
            }
            $this->dispatch('close-modal');
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    #[On('edit-vehicle-category')]
    public function editVehicleCategory(VehicleCategory $vehicleCategory){
        $this->vehicleCategory = $vehicleCategory;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    #[On('reset-form')]
    public function resetvehicleCategory()
    {
        $this->reset(['vehicleCategory', 'action']);
        $this->vehicleCategory = new VehicleCategory();
    }
}
