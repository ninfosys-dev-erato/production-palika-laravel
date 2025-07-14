<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\FuelDemandAdminDto;
use Src\Yojana\Models\FuelDemand;
use Src\Yojana\Service\FuelDemandAdminService;

class FuelDemandForm extends Component
{
    use SessionFlash;

    public ?FuelDemand $fuelDemand;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'fuelDemand.fuel_id' => ['required'],
    'fuelDemand.equipment_id' => ['required'],
    'fuelDemand.quantity' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'fuelDemand.fuel_id.required' => __('yojana::yojana.fuel_id_is_required'),
            'fuelDemand.equipment_id.required' => __('yojana::yojana.equipment_id_is_required'),
            'fuelDemand.quantity.required' => __('yojana::yojana.quantity_is_required'),
        ];
    }

    public function render(){
        return view("FuelDemands::projects.form");
    }

    public function mount(FuelDemand $fuelDemand,Action $action)
    {
        $this->fuelDemand = $fuelDemand;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = FuelDemandAdminDto::fromLiveWireModel($this->fuelDemand);
        $service = new FuelDemandAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Fuel Demand Created Successfully");
                return redirect()->route('admin.fuel_demands.index');
                break;
            case Action::UPDATE:
                $service->update($this->fuelDemand,$dto);
                $this->successFlash("Fuel Demand Updated Successfully");
                return redirect()->route('admin.fuel_demands.index');
                break;
            default:
                return redirect()->route('admin.fuel_demands.index');
                break;
        }
    }
}
