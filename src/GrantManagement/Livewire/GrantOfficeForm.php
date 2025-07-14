<?php

namespace Src\GrantManagement\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\GrantManagement\Controllers\GrantOfficeAdminController;
use Src\GrantManagement\DTO\GrantOfficeAdminDto;
use Src\GrantManagement\Models\GrantOffice;
use Src\GrantManagement\Service\GrantOfficeAdminService;
use Livewire\Attributes\On;

class GrantOfficeForm extends Component
{
    use SessionFlash;

    public ?GrantOffice $grantOffice;
    public ?Action $action = Action::CREATE;

    public function rules(): array
    {
        return [
            'grantOffice.office_name' => ['required'],
            'grantOffice.office_name_en' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'grantOffice.office_name.required' => __('grantmanagement::grantmanagement.office_name_is_required'),
            'grantOffice.office_name_en.required' => __('grantmanagement::grantmanagement.office_name_en_is_required'),
        ];
    }

    public function render()
    {
        return view("GrantManagement::livewire.grant-offices-form");
    }

    public function mount(GrantOffice $grantOffice, Action $action)
    {
        $this->grantOffice = $grantOffice;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = GrantOfficeAdminDto::fromLiveWireModel($this->grantOffice);
        $service = new GrantOfficeAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('grantmanagement::grantmanagement.grant_office_created_successfully'));
                // return redirect()->route('admin.grant_offices.index');
                $this->dispatch('close-modal');
                $this->resetForm();

                break;
            case Action::UPDATE:
                $service->update($this->grantOffice, $dto);
                $this->successFlash(__('grantmanagement::grantmanagement.grant_office_updated_successfully'));
                // return redirect()->route('admin.grant_offices.index');
                $this->dispatch('close-modal');
                $this->resetForm();

                break;
            default:
                return redirect()->route('admin.grant_offices.index');
                break;
        }
    }

    #[On('edit-grant-office')]
    public function editGrantOffice(GrantOffice $grantOffice)
    {
        $this->grantOffice = $grantOffice;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['grantOffice', 'action']);
        $this->grantOffice = new GrantOffice();
    }
    #[On('reset-form')]
    public function resetGrantOffice()
    {
        $this->resetForm();
    }
}
