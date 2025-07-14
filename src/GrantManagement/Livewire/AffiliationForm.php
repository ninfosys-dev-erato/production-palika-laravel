<?php

namespace Src\GrantManagement\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\GrantManagement\Controllers\AffiliationAdminController;
use Src\GrantManagement\DTO\AffiliationAdminDto;
use Src\GrantManagement\Models\Affiliation;
use Src\GrantManagement\Service\AffiliationAdminService;
use Livewire\Attributes\On;

class AffiliationForm extends Component
{
    use SessionFlash;

    public ?Affiliation $affiliation;
    public ?Action $action = Action::CREATE;

    public function rules(): array
    {
        return [
            'affiliation.title' => ['required'],
            'affiliation.title_en' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'affiliation.title.required' => __('grantmanagement::grantmanagement.title_is_required'),
            'affiliation.title_en.required' => __('grantmanagement::grantmanagement.title_en_is_required'),
        ];
    }

    public function render()
    {
        return view("GrantManagement::livewire.affiliations-form");
    }

    public function mount(Affiliation $affiliation, Action $action)
    {
        $this->affiliation = $affiliation;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = AffiliationAdminDto::fromLiveWireModel($this->affiliation);
        $service = new AffiliationAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('grantmanagement::grantmanagement.affiliation_created_successfully'));
                // return redirect()->route('admin.affiliations.index');
                $this->dispatch('close-modal');
                $this->resetForm();
                break;
            case Action::UPDATE:
                $service->update($this->affiliation, $dto);
                $this->successFlash(__('grantmanagement::grantmanagement.affiliation_updated_successfully'));
                // return redirect()->route('admin.affiliations.index');
                $this->dispatch('close-modal');
                $this->resetForm();
                break;
            default:
                return redirect()->route('admin.affiliations.index');
                break;
        }
    }

    #[On('edit-affiliation-type')]
    public function editEnterpriseType(Affiliation $affiliation)
    {
        $this->affiliation = $affiliation;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['affiliation', 'action']);
        $this->affiliation = new Affiliation();
    }
    #[On('reset-form')]
    public function resetAffiliation()
    {
        $this->resetForm();
    }
}
