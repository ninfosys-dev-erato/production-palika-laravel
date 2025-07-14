<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Rules\MobileNumberIdentifierRule;
use App\Traits\SessionFlash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Src\Ejalas\DTO\JudicialCommitteeAdminDto;
use Src\Ejalas\Models\JudicialCommittee;
use Src\Ejalas\Service\JudicialCommitteeAdminService;
use Livewire\Attributes\On;

class JudicialCommitteeForm extends Component
{
    use SessionFlash;

    public ?JudicialCommittee $judicialCommittee;
    public ?Action $action = Action::CREATE;

    public function rules(): array
    {
        return [
            'judicialCommittee.committees_title' => ['required'],
            'judicialCommittee.short_title' => ['required'],
            'judicialCommittee.title' => ['required'],
            'judicialCommittee.subtitle' => ['required'],
            'judicialCommittee.formation_date' => ['required'],
            'judicialCommittee.phone_no' => ['required', 'numeric', 'digits:10', Rule::unique('jms_judicial_committees', 'phone_no'), new MobileNumberIdentifierRule()],
            'judicialCommittee.email' => ['required'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.judicial-committee.form");
    }

    public function mount(JudicialCommittee $judicialCommittee, Action $action)
    {
        $this->judicialCommittee = $judicialCommittee;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try {
            $dto = JudicialCommitteeAdminDto::fromLiveWireModel($this->judicialCommittee);
            $service = new JudicialCommitteeAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ejalas::ejalas.judicial_committee_created_successfully'));
                    // return redirect()->route('admin.ejalas.judicial_committees.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                case Action::UPDATE:
                    $service->update($this->judicialCommittee, $dto);
                    $this->successFlash(__('ejalas::ejalas.judicial_committee_updated_successfully'));
                    // return redirect()->route('admin.ejalas.judicial_committees.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();

                    break;
                default:
                    return redirect()->route('admin.ejalas.judicial_committees.index');
                    break;
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    #[On('edit-judicial-committee')]
    public function editJudicialCommittee(JudicialCommittee $judicialCommittee)
    {
        $this->judicialCommittee = $judicialCommittee;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['judicialCommittee', 'action']);
        $this->judicialCommittee = new JudicialCommittee();
    }
    #[On('reset-form')]
    public function resetJudicialCommittee()
    {
        $this->resetForm();
    }
}
