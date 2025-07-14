<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\Yojana\DTO\MeasurementUnitAdminDto;
use Src\Yojana\Models\MeasurementUnit;
use Src\Yojana\Models\Type;
use Src\Yojana\Models\Unit;
use Src\Yojana\Service\MeasurementUnitAdminService;

class MeasurementUnitForm extends Component
{
    use SessionFlash;

    public ?MeasurementUnit $measurementUnit;
    public ?Action $action = Action::CREATE;
    public $types = [];

    public function rules(): array
    {
        return [
    'measurementUnit.type_id' => ['required'],
    'measurementUnit.title' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'measurementUnit.type_id.required' => __('yojana::yojana.type_id_is_required'),
            'measurementUnit.title.required' => __('yojana::yojana.title_is_required'),
        ];
    }

    public function render(){
        return view("Yojana::livewire.measurement-units.form");
    }

    public function mount(MeasurementUnit $measurementUnit,Action $action)
    {
        $this->measurementUnit = $measurementUnit;
        $this->action = $action;
        $this->types = Type::whereNull('deleted_at')->get();
    }

    public function save()
    {
        $this->validate();
        $dto = MeasurementUnitAdminDto::fromLiveWireModel($this->measurementUnit);
        $service = new MeasurementUnitAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successToast(__('yojana::yojana.measurement_unit_created_successfully'));
//                return redirect()->route('admin.measurement_units.index');
                $this->resetForm();
                break;
            case Action::UPDATE:
                $service->update($this->measurementUnit,$dto);
                $this->successToast(__('yojana::yojana.measurement_unit_updated_successfully'));
//                return redirect()->route('admin.measurement_units.index');
                $this->resetForm();
                break;
            default:
                return redirect()->route('admin.measurement_units.index');
                break;
        }
        $this->dispatch('close-modal');
    }
    #[On('edit-measurement-unit')]
    public function editMeasurementUnit(MeasurementUnit $measurementUnit){
        $this->measurementUnit = $measurementUnit;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['measurementUnit', 'action']);
        $this->measurementUnit = new MeasurementUnit();
    }
    #[On('reset-form')]
    public function resetMeasurementUnit()
    {
        $this->resetForm();
    }
}

