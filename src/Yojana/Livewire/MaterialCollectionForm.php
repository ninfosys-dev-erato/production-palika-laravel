<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\MaterialCollectionAdminDto;
use Src\Yojana\Models\MaterialCollection;
use Src\Yojana\Service\MaterialCollectionAdminService;

class MaterialCollectionForm extends Component
{
    use SessionFlash;

    public ?MaterialCollection $materialCollection;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'materialCollection.material_rate_id' => ['required'],
    'materialCollection.unit_id' => ['required'],
    'materialCollection.activity_no' => ['required'],
    'materialCollection.remarks' => ['required'],
    'materialCollection.fiscal_year_id' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'materialCollection.material_rate_id.required' => __('yojana::yojana.material_rate_id_is_required'),
            'materialCollection.unit_id.required' => __('yojana::yojana.unit_id_is_required'),
            'materialCollection.activity_no.required' => __('yojana::yojana.activity_no_is_required'),
            'materialCollection.remarks.required' => __('yojana::yojana.remarks_is_required'),
            'materialCollection.fiscal_year_id.required' => __('yojana::yojana.fiscal_year_id_is_required'),
        ];
    }

    public function render(){
        return view("MaterialCollections::livewire.form");
    }

    public function mount(MaterialCollection $materialCollection,Action $action)
    {
        $this->materialCollection = $materialCollection;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = MaterialCollectionAdminDto::fromLiveWireModel($this->materialCollection);
        $service = new MaterialCollectionAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Material Collection Created Successfully");
                return redirect()->route('admin.material_collections.index');
                break;
            case Action::UPDATE:
                $service->update($this->materialCollection,$dto);
                $this->successFlash("Material Collection Updated Successfully");
                return redirect()->route('admin.material_collections.index');
                break;
            default:
                return redirect()->route('admin.material_collections.index');
                break;
        }
    }
}
