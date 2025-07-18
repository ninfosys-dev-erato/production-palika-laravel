<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\SourceTypeAdminDto;
use Src\Yojana\Models\SourceType;
use Src\Yojana\Service\SourceTypeAdminService;
use Livewire\Attributes\On;

class SourceTypeForm extends Component
{
    use SessionFlash;

    public ?SourceType $sourceType;
    public ?Action $action = Action::CREATE;

    public function rules(): array
    {
        return [
            'sourceType.title' => ['required'],
            'sourceType.code' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'sourceType.title.required' => __('yojana::yojana.title_is_required'),
            'sourceType.code.required' => __('yojana::yojana.code_is_required'),
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.source-types.form");
    }

    public function mount(SourceType $sourceType, Action $action)
    {
        $this->sourceType = $sourceType;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = SourceTypeAdminDto::fromLiveWireModel($this->sourceType);
        $service = new SourceTypeAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.source_type_created_successfully'));
                $this->dispatch('close-modal');
//                return redirect()->route('admin.source_types.index');
                break;
            case Action::UPDATE:
                $service->update($this->sourceType, $dto);
                $this->successFlash(__('yojana::yojana.source_type_updated_successfully'));
                $this->dispatch('close-modal');
//                return redirect()->route('admin.source_types.index');
                break;
            default:
                return redirect()->route('admin.source_types.index');
                break;
        }
    }
    #[On('edit-sourceType')]
    public function editSourceType(SourceType $sourceType)
    {
        $this->sourceType = $sourceType;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    #[On('reset-form')]
    public function resetConfiguration()
    {
        $this->reset(['sourceType', 'action']);
        $this->sourceType = new SourceType();
    }
}
