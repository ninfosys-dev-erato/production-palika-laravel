<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\JudicialMeetingAdminDto;
use Src\Ejalas\Models\JudicialEmployee;
use Src\Ejalas\Models\JudicialMeeting;
use Src\Ejalas\Models\JudicialMember;
use Src\Ejalas\Service\JudicialMeetingAdminService;
use Src\FiscalYears\Models\FiscalYear;

class JudicialMeetingForm extends Component
{
    use SessionFlash;

    public ?JudicialMeeting $judicialMeeting;
    public ?Action $action;
    public $fiscalYears;
    public $judicialMembers;
    public $judicialEmployees;
    public $invited_employee_ids = [];
    public $members_present_ids = [];
    public $savedMeeting;

    public function rules(): array
    {
        return [
            'judicialMeeting.fiscal_year_id' => ['required'],
            'judicialMeeting.meeting_date' => ['required'],
            'judicialMeeting.meeting_time' => ['required'],
            'judicialMeeting.meeting_number' => ['required'],
            'judicialMeeting.decision_number' => ['required'],
            // 'judicialMeeting.invited_employee_id' => ['required'],
            // 'judicialMeeting.members_present_id' => ['required'],
            'judicialMeeting.meeting_topic' => ['required'],
            'judicialMeeting.decision_details' => ['required'],
            'invited_employee_ids' => ['required', 'array', 'min:1'],
            'members_present_ids' => ['required', 'array', 'min:1'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.judicial-meeting.form");
    }

    public function mount(JudicialMeeting $judicialMeeting, Action $action)
    {
        $this->judicialMeeting = $judicialMeeting;
        $this->action = $action;

        $this->fiscalYears = FiscalYear::whereNull('deleted_at')->pluck('year', 'id');
        $this->judicialMembers = JudicialMember::whereNull('deleted_at')->pluck('title', 'id');
        $this->judicialEmployees = JudicialEmployee::whereNull('deleted_at')->pluck('name', 'id');

        if ($action === Action::UPDATE) {
            $this->invited_employee_ids = $judicialMeeting->employees->pluck('id')->toArray();
            $this->members_present_ids = $judicialMeeting->members->pluck('id')->toArray();
        } else {
            $this->judicialMeeting->meeting_time = now()->format('H:i');
            $nextId = JudicialMeeting::max('id') + 1;
            $this->judicialMeeting->meeting_number = $nextId;
        }
    }

    public function save()
    {
        $this->validate();
        try {
            $dto = JudicialMeetingAdminDto::fromLiveWireModel($this->judicialMeeting);
            $service = new JudicialMeetingAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $this->savedMeeting  = $service->store($dto);
                    $this->successFlash(__('ejalas::ejalas.judicial_meeting_created_successfully'));
                    // return redirect()->route('admin.ejalas.judicial_meetings.index');
                    break;
                case Action::UPDATE:
                    $this->savedMeeting  = $service->update($this->judicialMeeting, $dto);
                    $this->successFlash(__('ejalas::ejalas.judicial_meeting_updated_successfully'));
                    // return redirect()->route('admin.ejalas.judicial_meetings.index');
                    break;
            }

            $this->savePivot($this->savedMeeting);
            return redirect()->route('admin.ejalas.judicial_meetings.index');
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
    //saves the data to the pivot table 
    public function savePivot($savedMeeting)
    {
        $savedMeeting->members()->sync($this->members_present_ids);
        $savedMeeting->employees()->sync($this->invited_employee_ids);
    }
}
