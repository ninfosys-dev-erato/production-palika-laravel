<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\Yojana\DTO\UnitTypeAdminDto;
use Src\Yojana\Models\Unit;
use Src\Yojana\Models\UnitType;
use Src\Yojana\Service\UnitTypeAdminService;

class UnitTypeForm extends Component
{
    use SessionFlash;

    public ?UnitType $unitType;
    public ?Action $action = Action::CREATE;
    public bool $willBeInUse = false;


    public function rules(): array
    {
        return [
    'unitType.title' => ['required'],
    'unitType.title_en' => ['required'],
    'unitType.display_order' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'unitType.title.required' => __('yojana::yojana.title_is_required'),
            'unitType.title_en.required' => __('yojana::yojana.title_en_is_required'),
            'unitType.display_order.required' => __('yojana::yojana.display_order_is_required'),
        ];
    }

    public function render(){
        return view("Yojana::livewire.unit-types.form");
    }

    public function mount(UnitType $unitType,Action $action)
    {
        $this->unitType = $unitType;
        $this->action = $action;

        if ($action === Action::UPDATE){
            $this->willBeInUse = $this->unitType->will_be_in_use;
        }
    }

    public function save()
    {
        $this->validate();
        $this->unitType->will_be_in_use = $this->willBeInUse;
        $dto = UnitTypeAdminDto::fromLiveWireModel($this->unitType);
        $service = new UnitTypeAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.unit_type_created_successfully'));
//                return redirect()->route('admin.unit_types.index');
                break;
            case Action::UPDATE:
                $service->update($this->unitType,$dto);
                $this->successFlash(__('yojana::yojana.unit_type_updated_successfully'));
//                return redirect()->route('admin.unit_types.index');
                break;
            default:
                return redirect()->route('admin.unit_types.index');
                break;
        }
        $this->dispatch('close-modal');
    }
    #[On('edit-unit-type')]
    public function editUnit(UnitType $unitType){
        $this->unitType = $unitType;
        $this->action = Action::UPDATE;
        $this->willBeInUse = $this->unitType->will_be_in_use;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['unitType', 'willBeInUse', 'action']);
        $this->unitType = new UnitType();
    }
    #[On('reset-form')]
    public function resetUnit()
    {
        $this->resetForm();
    }

}
