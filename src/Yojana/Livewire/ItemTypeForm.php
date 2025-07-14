<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\Yojana\DTO\ItemTypeAdminDto;
use Src\Yojana\Models\ItemType;
use Src\Yojana\Service\ItemTypeAdminService;

class ItemTypeForm extends Component
{
    use SessionFlash;

    public ?ItemType $itemType;
    public ?Action $action = Action::CREATE;

    public function rules(): array
    {
        return [
    'itemType.title' => ['required'],
    'itemType.code' => ['required'],
    'itemType.group' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'itemType.title.required' => __('yojana::yojana.title_is_required'),
            'itemType.code.required' => __('yojana::yojana.code_is_required'),
            'itemType.group.required' => __('yojana::yojana.group_is_required'),
        ];
    }

    public function render(){
        return view("Yojana::livewire.item-types.form");
    }

    public function mount(ItemType $itemType,Action $action)
    {
        $this->itemType = $itemType;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = ItemTypeAdminDto::fromLiveWireModel($this->itemType);
        $service = new ItemTypeAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.item_type_created_successfully'));
                break;
            case Action::UPDATE:
                $service->update($this->itemType,$dto);
                $this->successFlash(__('yojana::yojana.item_type_updated_successfully'));
                break;
            default:
                return redirect()->route('admin.item_types.index');
                break;
        }
        $this->dispatch('close-modal');
    }

    #[On('edit-item-type')]
    public function editItemType(ItemType $itemType){
        $this->itemType = $itemType;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }

    #[On('reset-form')]
    public function resetItemType()
    {
        $this->reset(['itemType', 'action']);
        $this->itemType = new ItemType();
    }
}
