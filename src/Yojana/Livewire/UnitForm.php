<?php

namespace Src\Yojana\Livewire;

use AllowDynamicProperties;
use App\Enums\Action;
use App\Traits\SessionFlash;
use Illuminate\Http\RedirectResponse;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\Yojana\DTO\UnitAdminDto;
use Src\Yojana\Models\MeasurementUnit;
use Src\Yojana\Models\Type;
use Src\Yojana\Models\Unit;
use Src\Yojana\Models\UnitType;
use Src\Yojana\Service\UnitAdminService;

#[AllowDynamicProperties] class UnitForm extends Component
{
    use SessionFlash;

    public ?Unit $unit;
    public ?Action $action = Action::CREATE;
    public  $types = [];
    public bool $willBeInUse = false;

    public function rules(): array
    {
        return [
    'unit.symbol' => ['required'],
    'unit.title' => ['required'],
    'unit.title_ne' => ['required'],
    'unit.type_id' => ['required']

];
    }
    public function messages(): array
    {
        return [
            'unit.symbol.required' => __('yojana::yojana.symbol_is_required'),
            'unit.title.required' => __('yojana::yojana.title_is_required'),
            'unit.title_ne.required' => __('yojana::yojana.title_ne_is_required'),
            'unit.type_id.required' => __('yojana::yojana.type_id_is_required'),
        ];
    }

    public function render(){
        return view("Yojana::livewire.units.form");
    }

    public function mount(Unit $unit,Action $action)
    {
        $this->unit = $unit;
        $this->action = $action;
        $this->types = UnitType::whereNull('deleted_at')->get();

        if ($action === Action::UPDATE){
            $this->willBeInUse = $this->unit->will_be_in_use;
        }
    }

    public function save()
    {
        $this->validate();
        $this->unit->will_be_in_use = $this->willBeInUse;
        $dto = UnitAdminDto::fromLiveWireModel($this->unit);
        $service = new UnitAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successToast(__('yojana::yojana.unit_created_successfully'));
//                return redirect()->route('admin.units.index');
                $this->resetForm();
                break;
            case Action::UPDATE:
                $service->update($this->unit,$dto);
                $this->successToast(__('yojana::yojana.unit_updated_successfully'));
                $this->resetForm();
//                return redirect()->route('admin.units.index');
                break;
            default:
                return redirect()->route('admin.units.index');
                break;
        }
        $this->dispatch('close-modal');
    }
    #[On('edit-unit')]
    public function editUnit(Unit $unit){
        $this->unit = $unit;
        $this->action = Action::UPDATE;
        $this->willBeInUse = $this->unit->will_be_in_use;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['unit', 'willBeInUse', 'action']);
        $this->unit = new Unit();
    }
    #[On('reset-form')]
    public function resetUnit()
    {
        $this->resetForm();
    }

}
