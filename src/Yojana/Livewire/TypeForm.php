<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\Yojana\DTO\TypeAdminDto;
use Src\Yojana\Models\Type;
use Src\Yojana\Models\Unit;
use Src\Yojana\Service\TypeAdminService;

class TypeForm extends Component
{
    use SessionFlash;

    public ?Type $type;
    public ?Action $action = Action::CREATE;

    public function rules(): array
    {
        return [
    'type.title' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'type.title.required' => __('yojana::yojana.title_is_required'),
        ];
    }

    public function render(){
        return view("Yojana::livewire.types.form");
    }

    public function mount(Type $type,Action $action)
    {
        $this->type = $type;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = TypeAdminDto::fromLiveWireModel($this->type);
        $service = new TypeAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successToast(__('yojana::yojana.type_created_successfully'));
//                return redirect()->route('admin.types.index');
                $this->resetForm();

                break;
            case Action::UPDATE:
                $service->update($this->type,$dto);
                $this->successToast(__('yojana::yojana.type_updated_successfully'));
//                return redirect()->route('admin.types.index');
                $this->resetForm();

                break;
            default:
                return redirect()->route('admin.types.index');
                break;
        }
        $this->dispatch('close-modal');
    }
    #[On('edit-type')]
    public function editType(Type $type){
        $this->type = $type;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['type', 'action']);
        $this->type = new Type();
    }
    #[On('reset-form')]
    public function resetType()
    {
        $this->resetForm();
    }
}
