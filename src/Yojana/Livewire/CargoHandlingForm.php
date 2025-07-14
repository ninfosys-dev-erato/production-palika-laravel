<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\CargoHandlingAdminDto;
use Src\Yojana\Models\CargoHandling;
use Src\Yojana\Service\CargoHandlingAdminService;

class CargoHandlingForm extends Component
{
    use SessionFlash;

    public ?CargoHandling $cargoHandling;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'cargoHandling.fiscal_year_id' => ['required'],
    'cargoHandling.unit_id' => ['required'],
    'cargoHandling.material_id' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'cargoHandling.fiscal_year_id.required' => __('yojana::yojana.fiscal_year_id_is_required'),
            'cargoHandling.unit_id.required' => __('yojana::yojana.unit_id_is_required'),
            'cargoHandling.material_id.required' => __('yojana::yojana.material_id_is_required'),
        ];
    }

    public function render(){
        return view("CargoHandlings::livewire.form");
    }

    public function mount(CargoHandling $cargoHandling,Action $action)
    {
        $this->cargoHandling = $cargoHandling;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = CargoHandlingAdminDto::fromLiveWireModel($this->cargoHandling);
        $service = new CargoHandlingAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Cargo Handling Created Successfully");
                return redirect()->route('admin.cargo_handlings.index');
                break;
            case Action::UPDATE:
                $service->update($this->cargoHandling,$dto);
                $this->successFlash("Cargo Handling Updated Successfully");
                return redirect()->route('admin.cargo_handlings.index');
                break;
            default:
                return redirect()->route('admin.cargo_handlings.index');
                break;
        }
    }
}
