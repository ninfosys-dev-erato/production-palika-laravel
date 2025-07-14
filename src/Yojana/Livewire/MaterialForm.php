<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\MaterialAdminDto;
use Src\Yojana\Models\Material;
use Src\Yojana\Service\MaterialAdminService;

class MaterialForm extends Component
{
    use SessionFlash;

    public ?Material $material;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'material.material_type_id' => ['required'],
    'material.unit_id' => ['required'],
    'material.title' => ['required'],
    'material.density' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'material.material_type_id.required' => __('yojana::yojana.material_type_id_is_required'),
            'material.unit_id.required' => __('yojana::yojana.unit_id_is_required'),
            'material.title.required' => __('yojana::yojana.title_is_required'),
            'material.density.required' => __('yojana::yojana.density_is_required'),
        ];
    }

    public function render(){
        return view("Materials::livewire.form");
    }

    public function mount(Material $material,Action $action)
    {
        $this->material = $material;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = MaterialAdminDto::fromLiveWireModel($this->material);
        $service = new MaterialAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Material Created Successfully");
                return redirect()->route('admin.materials.index');
                break;
            case Action::UPDATE:
                $service->update($this->material,$dto);
                $this->successFlash("Material Updated Successfully");
                return redirect()->route('admin.materials.index');
                break;
            default:
                return redirect()->route('admin.materials.index');
                break;
        }
    }
}
