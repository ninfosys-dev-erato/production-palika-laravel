<?php

namespace Src\Meetings\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\InvitedMembers\Controllers\InvitedMemberAdminController;
use Src\Meetings\DTO\InvitedMemberAdminDto;
use Src\Meetings\Models\InvitedMember;
use Src\Meetings\Service\InvitedMemberAdminService;
use Livewire\Attributes\On;

class InvitedMemberForm extends Component
{
    use SessionFlash;

    public ?InvitedMember $invitedMember;
    public ?Action $action;
    public ?int $meetingId;

    public function rules(): array
    {
        return [
            'invitedMember.name' => ['required', 'string'],
            'invitedMember.meeting_id' => ['required', 'integer', 'exists:met_meetings,id,deleted_at,NULL'],
            'invitedMember.designation' => ['required', 'string'],
            'invitedMember.phone' => ['required', 'string'],
            'invitedMember.email' => ['nullable', 'email'],
        ];
    }

    public function messages(): array
    {
        return [
            'invitedMember.name.required' => __('The invited member name is required.'),
            'invitedMember.name.string' => __('The invited member name must be a string.'),
            'invitedMember.meeting_id.required' => __('The meeting ID is required.'),
            'invitedMember.meeting_id.integer' => __('The meeting ID must be an integer.'),
            'invitedMember.meeting_id.exists' => __('The selected meeting ID is invalid.'),
            'invitedMember.designation.required' => __('The invited member designation is required.'),
            'invitedMember.designation.string' => __('The invited member designation must be a string.'),
            'invitedMember.phone.required' => __('The invited member phone is required.'),
            'invitedMember.phone.string' => __('The invited member phone must be a string.'),
            'invitedMember.email.required' => __('The invited member email is required.'),
            'invitedMember.email.email' => __('The invited member email must be a valid email address.'),
        ];
    }

    public function render(){
        return view("Meetings::livewire.invitedMember-form");
    }

    public function mount(InvitedMember $invitedMember,Action $action,int $meetingId)
    {
        $this->invitedMember = $invitedMember;
        $this->action = $action;
        $this->meetingId  = $meetingId;
        if (empty($invitedMember->meeting_id)){
            $this->invitedMember['meeting_id'] = $this->meetingId;
        }
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = InvitedMemberAdminDto::fromLiveWireModel($this->invitedMember);
            $service = new InvitedMemberAdminService();
            switch ($this->action){
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__("Invited Member Created Successfully"));
                    break;
                    case Action::UPDATE:
                        $service->update($this->invitedMember,$dto);
                        $this->successFlash(__("Invited Member Updated Successfully"));
                        break;
                        default:
                        break;
                    }
                    return redirect()->route('admin.meetings.manage', $this->invitedMember['meeting_id']);
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
    #[On('search-user')]
    public function restructureData(array $result)
    {
        $this->invitedMember->name = $result['name'];
        $this->invitedMember->phone = $result['mobile_no'];
        $this->invitedMember->email = $result['email'];
    }
}