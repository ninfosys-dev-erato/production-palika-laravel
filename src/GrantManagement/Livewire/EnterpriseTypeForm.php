<?php

namespace Src\GrantManagement\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\GrantManagement\Controllers\EnterpriseTypeAdminController;
use Src\GrantManagement\DTO\EnterpriseTypeAdminDto;
use Src\GrantManagement\Models\EnterpriseType;
use Src\GrantManagement\Service\EnterpriseTypeAdminService;
use Livewire\Attributes\On;

class EnterpriseTypeForm extends Component
{
    use SessionFlash;

    public ?EnterpriseType $enterpriseType;
    public ?Action $action = Action::CREATE;

    public function rules(): array
    {
        return [
            'enterpriseType.title' => ['required'],
            'enterpriseType.title_en' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'enterpriseType.title.required' => __('grantmanagement::grantmanagement.title_is_required'),
            'enterpriseType.title_en.required' => __('grantmanagement::grantmanagement.title_en_is_required'),
        ];
    }

    public function render()
    {
        return view("GrantManagement::livewire.enterprise-types-form");
    }

    public function mount(EnterpriseType $enterpriseType, Action $action)
    {
        $this->enterpriseType = $enterpriseType;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = EnterpriseTypeAdminDto::fromLiveWireModel($this->enterpriseType);
        $service = new EnterpriseTypeAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('grantmanagement::grantmanagement.enterprise_type_created_successfully'));
                $this->dispatch('close-modal');
                $this->resetForm();

                // return redirect()->route('admin.enterprise_types.index');
                break;
            case Action::UPDATE:
                $service->update($this->enterpriseType, $dto);
                $this->successFlash(__('grantmanagement::grantmanagement.enterprise_type_updated_successfully'));
                // return redirect()->route('admin.enterprise_types.index');
                
                $this->dispatch('close-modal');
                $this->resetForm();
                // $this->m
                break;
            default:
                return redirect()->route('admin.enterprise_types.index');
                break;
        }
    }

    #[On('edit-enterprise-type')]
    public function editEnterpriseType(EnterpriseType $enterpriseType)
    {
        $this->enterpriseType = $enterpriseType;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['enterpriseType', 'action']);
        $this->enterpriseType = new EnterpriseType();
    }
    #[On('reset-form')]
    public function resetEnterpriseType()
    {
        $this->resetForm();
    }
}
