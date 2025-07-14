<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\FuelAdminDto;
use Src\Yojana\Models\Fuel;
use Src\Yojana\Service\FuelAdminService;

class FuelForm extends Component
{
    use SessionFlash;

    public ?Fuel $fuel;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'fuel.title' => ['required'],
    'fuel.unit_id' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'fuel.title.required' => __('yojana::yojana.title_is_required'),
            'fuel.unit_id.required' => __('yojana::yojana.unit_id_is_required'),
        ];
    }

    public function render(){
        return view("Fuels::livewire.form");
    }

    public function mount(Fuel $fuel,Action $action)
    {
        $this->fuel = $fuel;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = FuelAdminDto::fromLiveWireModel($this->fuel);
        $service = new FuelAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Fuel Created Successfully");
                return redirect()->route('admin.fuels.index');
                break;
            case Action::UPDATE:
                $service->update($this->fuel,$dto);
                $this->successFlash("Fuel Updated Successfully");
                return redirect()->route('admin.fuels.index');
                break;
            default:
                return redirect()->route('admin.fuels.index');
                break;
        }
    }
}
