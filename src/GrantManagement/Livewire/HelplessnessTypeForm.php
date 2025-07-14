<?php

namespace Src\GrantManagement\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\GrantManagement\Controllers\HelplessnessTypeAdminController;
use Src\GrantManagement\DTO\HelplessnessTypeAdminDto;
use Src\GrantManagement\Models\HelplessnessType;
use Src\GrantManagement\Service\HelplessnessTypeAdminService;
use Livewire\Attributes\On;

class HelplessnessTypeForm extends Component
{
    use SessionFlash;

    public ?HelplessnessType $helplessnessType;
    public ?Action $action = Action::CREATE;

    public function rules(): array
    {
        return [
            'helplessnessType.helplessness_type' => ['required'],
            'helplessnessType.helplessness_type_en' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'helplessnessType.helplessness_type.required' => __('grantmanagement::grantmanagement.helplessness_type_is_required'),
            'helplessnessType.helplessness_type_en.required' => __('grantmanagement::grantmanagement.helplessness_type_en_is_required'),
        ];
    }

    public function render()
    {
        return view("GrantManagement::livewire.helplessness-types-form");
    }

    public function mount(HelplessnessType $helplessnessType, Action $action)
    {
        $this->helplessnessType = $helplessnessType;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = HelplessnessTypeAdminDto::fromLiveWireModel($this->helplessnessType);
        $service = new HelplessnessTypeAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('grantmanagement::grantmanagement.helplessness_type_created_successfully'));
                // return redirect()->route('admin.helplessness_types.index');
                $this->dispatch('close-modal');
                $this->resetForm();

                break;
            case Action::UPDATE:
                $service->update($this->helplessnessType, $dto);
                $this->successFlash(__('grantmanagement::grantmanagement.helplessness_type_updated_successfully'));
                // return redirect()->route('admin.helplessness_types.index');
                $this->dispatch('close-modal');
                $this->resetForm();

                break;
            default:
                return redirect()->route('admin.helplessness_types.index');
                break;
        }
    }

    #[On('edit-helplessness-type')]
    public function editHelplessnessType(HelplessnessType $helplessnessType)
    {
        $this->helplessnessType = $helplessnessType;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['helplessnessType', 'action']);
        $this->helplessnessType = new HelplessnessType();
    }
    #[On('reset-form')]
    public function resetHelplessnessType()
    {
        $this->resetForm();
    }
}
