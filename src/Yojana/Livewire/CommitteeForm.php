<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\CommitteeAdminDto;
use Src\Yojana\Models\Committee;
use Src\Yojana\Service\CommitteeAdminService;
use Livewire\Attributes\On;


class CommitteeForm extends Component
{
    use SessionFlash;

    public ?Committee $committee;
    public ?Action $action;

    public function rules(): array
    {
        return [
            'committee.committee_type_id' => ['required'],
            'committee.committee_name' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'committee.committee_type_id.required' => __('yojana::yojana.the_committee_type_id_is_required'),
            'committee.committee_name.required' => __('yojana::yojana.the_committee_name_is_required'),
        ];
    }
    public function render()
    {
        return view("Yojana::livewire.committees.form");
    }

    public function mount(Committee $committee, Action $action)
    {
        $this->committee = $committee;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = CommitteeAdminDto::fromLiveWireModel($this->committee);
        $service = new CommitteeAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.committee_created_successfully'));
                // return redirect()->route('admin.committees.index');
                break;
            case Action::UPDATE:
                $service->update($this->committee, $dto);
                $this->successFlash(__('yojana::yojana.committee_updated_successfully'));
                // return redirect()->route('admin.committees.index');
                break;
            default:
                return redirect()->route('admin.committees.index');
                break;
        }
    }

    #[On('edit-committee')]
    public function editCommittee(Committee $committee)
    {
        $this->committee = $committee;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['committee', 'action']);
        $this->committee = new Committee();
    }
    #[On('reset-form')]
    public function resetCommittee()
    {
        $this->resetForm();
    }
}
