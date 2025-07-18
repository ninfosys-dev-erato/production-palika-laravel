<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\Yojana\DTO\TargetAdminDto;
use Src\Yojana\Models\Target;
use Src\Yojana\Service\TargetAdminService;

class TargetForm extends Component
{
    use SessionFlash;

    public ?Target $target;
    public ?Action $action = Action::CREATE;

    public function rules(): array
    {
        return [
    'target.title' => ['required'],
    'target.code' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'target.title.required' => __('yojana::yojana.title_is_required'),
            'target.code.required' => __('yojana::yojana.code_is_required'),
        ];
    }

    public function render(){
        return view("Yojana::livewire.targets.form");
    }

    public function mount(Target $target,Action $action)
    {
        $this->target = $target;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = TargetAdminDto::fromLiveWireModel($this->target);
        $service = new TargetAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.target_created_successfully'));
//                return redirect()->route('admin.targets.index');
                break;
            case Action::UPDATE:
                $service->update($this->target,$dto);
                $this->successFlash(__('yojana::yojana.target_updated_successfully'));
//                return redirect()->route('admin.targets.index');
                break;
            default:
                return redirect()->route('admin.targets.index');
                break;
        }
        $this->dispatch('close-modal');
    }

    #[On('edit-target')]
    public function editTarget(Target $target){
        $this->target = $target;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }

    #[On('reset-form')]
    public function resetTarget()
    {
        $this->reset(['target', 'action']);
        $this->target = new Target();
    }
}

