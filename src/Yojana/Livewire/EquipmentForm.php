<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\EquipmentAdminDto;
use Src\Yojana\Models\Equipment;
use Src\Yojana\Service\EquipmentAdminService;

class EquipmentForm extends Component
{
    use SessionFlash;

    public ?Equipment $equipment;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'equipment.title' => ['required'],
    'equipment.activity' => ['required'],
    'equipment.is_used_for_transport' => ['required'],
    'equipment.capacity' => ['required'],
    'equipment.speed_with_out_load' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'equipment.title.required' => __('yojana::yojana.title_is_required'),
            'equipment.activity.required' => __('yojana::yojana.activity_is_required'),
            'equipment.is_used_for_transport.required' => __('yojana::yojana.is_used_for_transport_is_required'),
            'equipment.capacity.required' => __('yojana::yojana.capacity_is_required'),
            'equipment.speed_with_out_load.required' => __('yojana::yojana.speed_with_out_load_is_required'),
        ];
    }

    public function render(){
        return view("Equipment::livewire.form");
    }

    public function mount(Equipment $equipment,Action $action)
    {
        $this->equipment = $equipment;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = EquipmentAdminDto::fromLiveWireModel($this->equipment);
        $service = new EquipmentAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Equipment Created Successfully");
                return redirect()->route('admin.equipment.index');
                break;
            case Action::UPDATE:
                $service->update($this->equipment,$dto);
                $this->successFlash("Equipment Updated Successfully");
                return redirect()->route('admin.equipment.index');
                break;
            default:
                return redirect()->route('admin.equipment.index');
                break;
        }
    }
}
