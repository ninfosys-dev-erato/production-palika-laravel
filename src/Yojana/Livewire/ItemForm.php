<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\ItemAdminDto;
use Src\Yojana\Models\Item;
use Src\Yojana\Models\ItemType;
use Src\Yojana\Models\Unit;
use Src\Yojana\Service\ItemAdminService;

class ItemForm extends Component
{
    use SessionFlash;

    public ?Item $item;
    public ?Action $action;
    public  $types;
    public  $units;

    public function rules(): array
    {
        return [
    'item.title' => ['required'],
    'item.type_id' => ['required'],
    'item.code' => ['required'],
    'item.unit_id' => ['required'],
    'item.remarks' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'item.title.required' => __('yojana::yojana.title_is_required'),
            'item.type_id.required' => __('yojana::yojana.type_id_is_required'),
            'item.code.required' => __('yojana::yojana.code_is_required'),
            'item.unit_id.required' => __('yojana::yojana.unit_id_is_required'),
            'item.remarks.required' => __('yojana::yojana.remarks_is_required'),
        ];
    }

    public function render(){
        return view("Yojana::livewire.items.form");
    }

    public function mount(Item $item,Action $action)
    {
        $this->item = $item;
        $this->action = $action;
        $this->types = ItemType::whereNull('deleted_at')->get();
        $this->units = Unit::whereNull('deleted_at')->get();
    }

    public function save()
    {
        $this->validate();
        $dto = ItemAdminDto::fromLiveWireModel($this->item);
        $service = new ItemAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.item_created_successfully'));
                return redirect()->route('admin.items.index');
                break;
            case Action::UPDATE:
                $service->update($this->item,$dto);
                $this->successFlash(__('yojana::yojana.item_updated_successfully'));
                return redirect()->route('admin.items.index');
                break;
            default:
                return redirect()->route('admin.items.index');
                break;
        }
    }
}
