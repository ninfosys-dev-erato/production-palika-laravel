<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\FuelRates\Controllers\FuelRateAdminController;
use Src\Yojana\DTO\FuelRateAdminDto;
use Src\Yojana\Models\FuelRate;
use Src\Yojana\Service\FuelRateAdminService;

class FuelRateForm extends Component
{
    use SessionFlash;

    public ?FuelRate $fuelRate;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'fuelRate.fuel_id' => ['required'],
    'fuelRate.rate' => ['required'],
    'fuelRate.has_included_vat' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'fuelRate.fuel_id.required' => __('yojana::yojana.fuel_id_is_required'),
            'fuelRate.rate.required' => __('yojana::yojana.rate_is_required'),
            'fuelRate.has_included_vat.required' => __('yojana::yojana.has_included_vat_is_required'),
        ];
    }

    public function render(){
        return view("FuelRates::livewire.form");
    }

    public function mount(FuelRate $fuelRate,Action $action)
    {
        $this->fuelRate = $fuelRate;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = FuelRateAdminDto::fromLiveWireModel($this->fuelRate);
        $service = new FuelRateAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Fuel Rate Created Successfully");
                return redirect()->route('admin.fuel_rates.index');
                break;
            case Action::UPDATE:
                $service->update($this->fuelRate,$dto);
                $this->successFlash("Fuel Rate Updated Successfully");
                return redirect()->route('admin.fuel_rates.index');
                break;
            default:
                return redirect()->route('admin.fuel_rates.index');
                break;
        }
    }
}
