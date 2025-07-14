<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\CrewRateAdminDto;
use Src\Yojana\Models\CrewRate;
use Src\Yojana\Service\CrewRateAdminService;

class CrewRateForm extends Component
{
    use SessionFlash;

    public ?CrewRate $crewRate;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'crewRate.labour_id' => ['required'],
    'crewRate.equipment_id' => ['required'],
    'crewRate.quantity' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'crewRate.labour_id.required' => __('yojana::yojana.labour_id_is_required'),
            'crewRate.equipment_id.required' => __('yojana::yojana.equipment_id_is_required'),
            'crewRate.quantity.required' => __('yojana::yojana.quantity_is_required'),
        ];
    }

    public function render(){
        return view("CrewRates::livewire.form");
    }

    public function mount(CrewRate $crewRate,Action $action)
    {
        $this->crewRate = $crewRate;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = CrewRateAdminDto::fromLiveWireModel($this->crewRate);
        $service = new CrewRateAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Crew Rate Created Successfully");
                return redirect()->route('admin.crew_rates.index');
                break;
            case Action::UPDATE:
                $service->update($this->crewRate,$dto);
                $this->successFlash("Crew Rate Updated Successfully");
                return redirect()->route('admin.crew_rates.index');
                break;
            default:
                return redirect()->route('admin.crew_rates.index');
                break;
        }
    }
}
