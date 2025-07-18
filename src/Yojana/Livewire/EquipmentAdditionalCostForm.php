<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\EquipmentAdditionalCostAdminDto;
use Src\Yojana\Models\EquipmentAdditionalCost;
use Src\Yojana\Service\EquipmentAdditionalCostAdminService;

class EquipmentAdditionalCostForm extends Component
{
    use SessionFlash;

    public ?EquipmentAdditionalCost $equipmentAdditionalCost;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'equipmentAdditionalCost.equipment_id' => ['required'],
    'equipmentAdditionalCost.fiscal_year_id' => ['required'],
    'equipmentAdditionalCost.unit_id' => ['required'],
    'equipmentAdditionalCost.rate' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'equipmentAdditionalCost.equipment_id.required' => __('yojana::yojana.equipment_id_is_required'),
            'equipmentAdditionalCost.fiscal_year_id.required' => __('yojana::yojana.fiscal_year_id_is_required'),
            'equipmentAdditionalCost.unit_id.required' => __('yojana::yojana.unit_id_is_required'),
            'equipmentAdditionalCost.rate.required' => __('yojana::yojana.rate_is_required'),
        ];
    }

    public function render(){
        return view("equipment-additional-costs::projects.form");
    }

    public function mount(EquipmentAdditionalCost $equipmentAdditionalCost,Action $action)
    {
        $this->equipmentAdditionalCost = $equipmentAdditionalCost;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = EquipmentAdditionalCostAdminDto::fromLiveWireModel($this->equipmentAdditionalCost);
        $service = new EquipmentAdditionalCostAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Equipment Additional Cost Created Successfully");
                return redirect()->route('admin.equipment_additional_costs.index');
                break;
            case Action::UPDATE:
                $service->update($this->equipmentAdditionalCost,$dto);
                $this->successFlash("Equipment Additional Cost Updated Successfully");
                return redirect()->route('admin.equipment_additional_costs.index');
                break;
            default:
                return redirect()->route('admin.equipment_additional_costs.index');
                break;
        }
    }
}
