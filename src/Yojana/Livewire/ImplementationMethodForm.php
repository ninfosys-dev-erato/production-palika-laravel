<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\ImplementationMethodAdminDto;
use Src\Yojana\Enums\ImplementationMethods;
use Src\Yojana\Models\ImplementationMethod;
use Src\Yojana\Service\ImplementationMethodAdminService;
use Livewire\Attributes\On;

class ImplementationMethodForm extends Component
{
    use SessionFlash;

    public ?ImplementationMethod $implementationMethod;
    public $models;
    public ?Action $action = Action::CREATE;

    public function rules(): array
    {
        return [
            'implementationMethod.title' => ['required'],
            'implementationMethod.code' => ['required'],
            'implementationMethod.model' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'implementationMethod.title.required' => __('yojana::yojana.title_is_required'),
            'implementationMethod.code.required' => __('yojana::yojana.code_is_required'),
            'implementationMethod.model.required' => __('yojana::yojana.model_is_required'),
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.implementation-methods.form");
    }

    public function mount(ImplementationMethod $implementationMethod, Action $action)
    {
        $this->implementationMethod = $implementationMethod;
        $this->models = ImplementationMethods::getForWeb();
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = ImplementationMethodAdminDto::fromLiveWireModel($this->implementationMethod);
        $service = new ImplementationMethodAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.implementation_method_created_successfully'));
                $this->dispatch('close-modal');
                break;
            case Action::UPDATE:
                $service->update($this->implementationMethod, $dto);
                $this->successFlash(__('yojana::yojana.implementation_method_updated_successfully'));
                $this->dispatch('close-modal');

                break;
            default:
                break;
        }
    }

    #[On('edit-implementationMethod')]
    public function editConfiguration(ImplementationMethod $implementationMethod)
    {
        $this->implementationMethod = $implementationMethod;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    #[On('reset-form')]
    public function resetConfiguration()
    {
        $this->reset(['implementationMethod', 'action']);
        $this->implementationMethod = new ImplementationMethod();
    }
}
