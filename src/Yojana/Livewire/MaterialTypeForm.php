<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\MaterialTypeAdminDto;
use Src\Yojana\Models\MaterialType;
use Src\Yojana\Service\MaterialTypeAdminService;

class MaterialTypeForm extends Component
{
    use SessionFlash;

    public ?MaterialType $materialType;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'materialType.title' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'materialType.title.required' => __('yojana::yojana.title_is_required'),
        ];
    }

    public function render(){
        return view("MaterialTypes::livewire.form");
    }

    public function mount(MaterialType $materialType,Action $action)
    {
        $this->materialType = $materialType;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = MaterialTypeAdminDto::fromLiveWireModel($this->materialType);
        $service = new MaterialTypeAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Material Type Created Successfully");
                return redirect()->route('admin.material_types.index');
                break;
            case Action::UPDATE:
                $service->update($this->materialType,$dto);
                $this->successFlash("Material Type Updated Successfully");
                return redirect()->route('admin.material_types.index');
                break;
            default:
                return redirect()->route('admin.material_types.index');
                break;
        }
    }
}
