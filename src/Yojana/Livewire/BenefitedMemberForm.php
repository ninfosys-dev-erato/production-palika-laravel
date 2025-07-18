<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\BenefitedMemberAdminDto;
use Src\Yojana\Models\BenefitedMember;
use Src\Yojana\Service\BenefitedMemberAdminService;
use Livewire\Attributes\On;

class BenefitedMemberForm extends Component
{
    use SessionFlash;

    public ?BenefitedMember $benefitedMember;
    public ?Action $action = Action::CREATE;

    public function rules(): array
    {
        return [
            'benefitedMember.title' => ['required'],
            'benefitedMember.is_population' => ['nullable'],
        ];
    }
    public function messages(): array
    {
        return [
            'benefitedMember.title.required' => __('yojana::yojana.title_is_required'),
            'benefitedMember.is_population.nullable' => __('yojana::yojana.is_population_is_optional'),
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.benefited-members.form");
    }

    public function mount(BenefitedMember $benefitedMember, Action $action)
    {
        $this->benefitedMember = $benefitedMember;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = BenefitedMemberAdminDto::fromLiveWireModel($this->benefitedMember);
        $service = new BenefitedMemberAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.benefited_member_created_successfully'));
                $this->dispatch('close-modal');
//                return redirect()->route('admin.benefited_members.index');
                break;
            case Action::UPDATE:
                $service->update($this->benefitedMember, $dto);
                $this->successFlash(__('yojana::yojana.benefited_member_updated_successfully'));
                $this->dispatch('close-modal');
//                return redirect()->route('admin.benefited_members.index');
                break;
            default:
                return redirect()->route('admin.benefited_members.index');
                break;
        }
    }
    #[On('edit-benefitedMember')]
    public function editSubRegion(BenefitedMember $benefitedMember)
    {
        $this->benefitedMember = $benefitedMember;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    #[On('reset-form')]
    public function resetConfiguration()
    {
        $this->reset(['benefitedMember', 'action']);
        $this->benefitedMember = new BenefitedMember();
    }
}
