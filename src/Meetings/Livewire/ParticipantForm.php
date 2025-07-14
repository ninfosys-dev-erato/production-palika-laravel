<?php

namespace Src\Meetings\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Meetings\DTO\ParticipantAdminDto;
use Src\Meetings\Models\Meeting;
use Src\Meetings\Models\Participant;
use Src\Meetings\Service\ParticipantAdminService;
use Src\Yojana\Models\CommitteeMember;

class ParticipantForm extends Component
{
    use SessionFlash;

    public Meeting $meeting;
    public ?Participant $participant;
    public ?Action $action;
    public $committeeMembers = [];
    public $committee_member_id ;

    public $meetingId;
    public $showMemberModal = false;

    public bool $intersectingMeetingsCheck = true;

    public function rules(): array
    {
        return [
            // 'participant.meeting_id' => ['integer', 'exists:met_meetings,id,deleted_at,NULL'],
            // 'participant.committee_member_id' => ['required', 'integer', 'exists:met_committee_members,id,deleted_at,NULL'],
            'participant.name' => ['required', 'string'],
            'participant.designation' => ['required', 'string'],
            'participant.phone' => ['required', 'string'],
            'participant.email' => ['required', 'email'],
        ];
    }

    public function openMemberModal()
    {
        $this->showMemberModal = true;
    }

    public function closeMemberModal()
    {
        $this->showMemberModal = false;
    }

    public function render()
    {
        return view("Meetings::livewire.participant-form");
    }

    public function mount(Participant $participant, Action $action, $meetingId)
    {

        $this->meeting = Meeting::where('id', $meetingId)->first();
        $this->committeeMembers = CommitteeMember::where('committee_id', $this->meeting->committee_id)->get();
        $this->participant = $participant;
        $this->action = $action;
        $this->meetingId = $meetingId;
        if (empty($participant->meeting_id)) {
            $this->participant['meeting_id'] = $this->meetingId;
        }
    }

    public function loadCommitteeMemberInformation($committeeMemberId)
    {
        if (!empty($committeeMemberId)) {
            $committeeMember = $this->committeeMembers->where('id', $committeeMemberId)->first();

            if ($committeeMember) {

                $this->participant->name = $committeeMember->name;
                $this->participant->designation = $committeeMember->designation;
                $this->participant->phone = $committeeMember->phone;
                $this->participant->email = $committeeMember->email;
            }
        }
        $this->committee_member_id = $committeeMemberId;

    }

    public function save()
    {
       $this->validate();
       if (!$this->checkMembers()) {
        return;
    }
       $this->participant->committee_member_id = $this->committee_member_id;
       $this->participant->meeting_id = $this->meetingId;

       try{
            $dto = ParticipantAdminDto::fromLiveWireModel($this->participant);
            $service = new ParticipantAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__("Participant Created Successfully"));
                    break;
                case Action::UPDATE:
                    $service->update($this->participant, $dto);
                    $this->successFlash(__("Participant Updated Successfully"));
                    break;
                default:
                    break;
            }
            return redirect()->route('admin.meetings.manage', $this->participant['meeting_id']);
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
    public function checkMembers()
    {
        $givenStartDate = $this->meeting['en_start_date'];
        $givenEndDate = $this->meeting['en_end_date'];
        $currentMeetingPhones = $this->meeting->participants->pluck('phone')->toArray();

        $currentOParticipantPhone = $this->participant->phone;
        if (in_array($currentOParticipantPhone, $currentMeetingPhones)) {
            $this->errorFlash(__("A participant with the same phone number is already in this meeting."));
            return false;
        }

        $conflictingMeetings = Meeting::where(function ($query) use ($givenStartDate, $givenEndDate) {
                $query->whereBetween('en_start_date', [$givenStartDate, $givenEndDate])
                      ->orWhereBetween('en_end_date', [$givenStartDate, $givenEndDate])
                      ->orWhere(function ($q) use ($givenStartDate, $givenEndDate) {
                          $q->where('en_start_date', '<=', $givenStartDate)
                            ->where('en_end_date', '>=', $givenEndDate);
                      });
            })
            ->whereHas('participants', function ($query) use ($currentOParticipantPhone) {
                $query->where('phone', $currentOParticipantPhone);
            })
            ->exists();

        if ($conflictingMeetings) {
            $this->errorFlash(__("The participant is already in another meeting during this time."));
            return false;
        }

        return true;
    }
}
