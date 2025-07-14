<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\ImplementationLevelAdminDto;
use Src\Yojana\Models\ImplementationLevel;
use Src\Yojana\Service\ImplementationLevelAdminService;
use Livewire\Attributes\On;

class ImplementationLevelForm extends Component
{
    use SessionFlash;

    public ?ImplementationLevel $implementationLevel;
    public ?Action $action = Action::CREATE;

    public function rules(): array
    {
        return [
            'implementationLevel.title' => ['required'],
            'implementationLevel.code' => ['required'],
            'implementationLevel.threshold' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'implementationLevel.title.required' => __('yojana::yojana.title_is_required'),
            'implementationLevel.code.required' => __('yojana::yojana.code_is_required'),
            'implementationLevel.threshold.required' => __('yojana::yojana.threshold_is_required'),
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.implementation-levels.form");
    }

    public function mount(ImplementationLevel $implementationLevel, Action $action)
    {
        $this->implementationLevel = $implementationLevel;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = ImplementationLevelAdminDto::fromLiveWireModel($this->implementationLevel);
        $service = new ImplementationLevelAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.implementation_level_created_successfully'));
                $this->dispatch('close-modal');
//                return redirect()->route('admin.implementation_levels.index');
                break;
            case Action::UPDATE:
                $service->update($this->implementationLevel, $dto);
                $this->successFlash(__('yojana::yojana.implementation_level_updated_successfully'));
                $this->dispatch('close-modal');
//                return redirect()->route('admin.implementation_levels.index');
                break;
            default:
                return redirect()->route('admin.implementation_levels.index');
                break;
        }
    }

    #[On('edit-implementationLevel')]
    public function editConfiguration(ImplementationLevel $implementationLevel)
    {
        $this->implementationLevel = $implementationLevel;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    #[On('reset-form')]
    public function resetConfiguration()
    {
        $this->reset(['implementationLevel', 'action']);
        $this->implementationLevel = new ImplementationLevel();
    }
}
