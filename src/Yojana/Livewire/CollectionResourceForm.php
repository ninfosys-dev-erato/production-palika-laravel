<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\CollectionResourceAdminDto;
use Src\Yojana\Models\CollectionResource;
use Src\Yojana\Service\CollectionResourceAdminService;

class CollectionResourceForm extends Component
{
    use SessionFlash;

    public ?CollectionResource $collectionResource;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'collectionResource.model_type' => ['required'],
    'collectionResource.model_id' => ['required'],
    'collectionResource.collectable' => ['required'],
    'collectionResource.type' => ['required'],
    'collectionResource.quantity' => ['required'],
    'collectionResource.rate_type' => ['required'],
    'collectionResource.rate' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'collectionResource.model_type.required' => __('yojana::yojana.model_type_is_required'),
            'collectionResource.model_id.required' => __('yojana::yojana.model_id_is_required'),
            'collectionResource.collectable.required' => __('yojana::yojana.collectable_is_required'),
            'collectionResource.type.required' => __('yojana::yojana.type_is_required'),
            'collectionResource.quantity.required' => __('yojana::yojana.quantity_is_required'),
            'collectionResource.rate_type.required' => __('yojana::yojana.rate_type_is_required'),
            'collectionResource.rate.required' => __('yojana::yojana.rate_is_required'),
        ];
    }

    public function render(){
        return view("CollectionResources::livewire.form");
    }

    public function mount(CollectionResource $collectionResource,Action $action)
    {
        $this->collectionResource = $collectionResource;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = CollectionResourceAdminDto::fromLiveWireModel($this->collectionResource);
        $service = new CollectionResourceAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Collection Resource Created Successfully");
                return redirect()->route('admin.collection_resources.index');
                break;
            case Action::UPDATE:
                $service->update($this->collectionResource,$dto);
                $this->successFlash("Collection Resource Updated Successfully");
                return redirect()->route('admin.collection_resources.index');
                break;
            default:
                return redirect()->route('admin.collection_resources.index');
                break;
        }
    }
}
