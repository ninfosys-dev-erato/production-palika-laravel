<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\NormTypeAdminDto;
use Src\Yojana\Models\NormType;
use Src\Yojana\Service\NormTypeAdminService;
use Livewire\Attributes\On;

class NormTypeForm extends Component
{
    use SessionFlash;

    public ?NormType $normType;
    public ?Action $action = Action::CREATE;

    public function rules(): array
    {
        return [
            'normType.title' => ['required'],
            'normType.authority_name' => ['required'],
            'normType.year' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'normType.title.required' => __('yojana::yojana.title_is_required'),
            'normType.authority_name.required' => __('yojana::yojana.authority_name_is_required'),
            'normType.year.required' => __('yojana::yojana.year_is_required'),
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.norm-types.form");
    }

    public function mount(NormType $normType, Action $action)
    {
        $this->normType = $normType;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = NormTypeAdminDto::fromLiveWireModel($this->normType);
        $service = new NormTypeAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.norm_type_created_successfully'));
                $this->dispatch('close-modal');
//                return redirect()->route('admin.norm_types.index');
                break;
            case Action::UPDATE:
                $service->update($this->normType, $dto);
                $this->successFlash(__('yojana::yojana.norm_type_updated_successfully'));
                $this->dispatch('close-modal');
//                return redirect()->route('admin.norm_types.index');
                break;
            default:
                return redirect()->route('admin.norm_types.index');
                break;
        }
    }
    #[On('edit-normType')]
    public function editNormType(NormType $normType): void
    {
        $this->normType = $normType;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    #[On('reset-form')]
    public function resetConfiguration()
    {
        $this->reset(['normType', 'action']);
        $this->normType = new NormType();
    }
}
