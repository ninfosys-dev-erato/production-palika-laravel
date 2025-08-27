<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\JudicialMemberAdminDto;
use Src\Ejalas\Enum\ElectedPosition;
use Src\Ejalas\Enum\JudicialMemberPosition;
use Src\Ejalas\Models\JudicialMember;
use Src\Ejalas\Service\JudicialMemberAdminService;
use Livewire\Attributes\On;

class JudicialMemberForm extends Component
{
    use SessionFlash;

    public ?JudicialMember $judicialMember;
    public ?Action $action = Action::CREATE;
    public $judicalMemberPositions;
    public $electedPositions;

    public function rules(): array
    {
        return [
            'judicialMember.title' => ['required'],
            'judicialMember.member_position' => ['required'],
            'judicialMember.elected_position' => ['required'],
            'judicialMember.status' => ['nullable'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.judicial-member.form");
    }

    public function mount(JudicialMember $judicialMember, Action $action)
    {
        $this->judicialMember = $judicialMember;
        $this->action = $action;
        $this->judicalMemberPositions = JudicialMemberPosition::getForWeb();
        $this->electedPositions = ElectedPosition::getForWeb();
    }

    public function save()
    {
        $this->validate();
        try {

            $dto = JudicialMemberAdminDto::fromLiveWireModel($this->judicialMember);
            $service = new JudicialMemberAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ejalas::ejalas.judicial_member_created_successfully'));
                    // return redirect()->route('admin.ejalas.judicial_members.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                case Action::UPDATE:
                    $service->update($this->judicialMember, $dto);
                    $this->successFlash(__('ejalas::ejalas.judicial_member_updated_successfully'));
                    // return redirect()->route('admin.ejalas.judicial_members.index');
                    $this->dispatch('close-modal');
                    $this->resetForm();
                    break;
                default:
                    return redirect()->route('admin.ejalas.judicial_members.index');
                    break;
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }


    #[On('edit-judicial-members')]
    public function editJudicialMember(JudicialMember $judicialMember)
    {
        $this->judicialMember = $judicialMember;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['judicialMember', 'action']);
        $this->judicialMember = new JudicialMember();
    }
    #[On('reset-form')]
    public function resetJudicialMember()
    {
        $this->resetForm();
    }
}
