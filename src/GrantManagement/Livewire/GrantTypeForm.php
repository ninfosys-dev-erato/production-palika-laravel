<?php

namespace Src\GrantManagement\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\GrantManagement\Controllers\GrantTypeAdminController;
use Src\GrantManagement\DTO\GrantTypeAdminDto;
use Src\GrantManagement\Models\GrantType;
use Src\GrantManagement\Service\GrantTypeAdminService;
use Livewire\Attributes\On;
use Src\Employees\Models\Branch;

class GrantTypeForm extends Component
{
    use SessionFlash;

    public ?GrantType $grantType;
    public ?Action $action = Action::CREATE;
    public $branches;

    public function rules(): array
    {
        return [
            'grantType.title' => ['required'],
            'grantType.title_en' => ['required'],
            'grantType.amount' => ['required'],
            'grantType.department' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'grantType.title.required' => __('grantmanagement::grantmanagement.title_is_required'),
            'grantType.title_en.required' => __('grantmanagement::grantmanagement.title_en_is_required'),
            'grantType.amount.required' => __('grantmanagement::grantmanagement.amount_is_required'),
            'grantType.department.required' => __('grantmanagement::grantmanagement.department_is_required'),
        ];
    }

    public function render()
    {
        return view("GrantManagement::livewire.grant-types-form");
    }

    public function mount(GrantType $grantType, Action $action)
    {
        $this->grantType = $grantType;
        $this->action = $action;
        $this->branches = Branch::whereNull('deleted_by')->get()->pluck('title', 'id')->toArray();
    }

    public function save()
    {
        $this->validate();
        $dto = GrantTypeAdminDto::fromLiveWireModel($this->grantType);
        $service = new GrantTypeAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('grantmanagement::grantmanagement.grant_type_created_successfully'));
                // return redirect()->route('admin.grant_types.index');
                $this->dispatch('close-modal');
                $this->resetForm();

                break;
            case Action::UPDATE:
                $service->update($this->grantType, $dto);
                $this->successFlash(__('grantmanagement::grantmanagement.grant_type_updated_successfully'));
                // return redirect()->route('admin.grant_types.index');
                $this->dispatch('close-modal');
                $this->resetForm();

                break;
            default:
                return redirect()->route('admin.grant_types.index');
                break;
        }
    }



    #[On('edit-grand-type')]
    public function editGrantType(GrantType $grantType)
    {
        $this->grantType = $grantType;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['grantType', 'action']);
        $this->grantType = new GrantType();
    }
    #[On('reset-form')]
    public function resetGrantType()
    {
        $this->resetForm();
    }
}
