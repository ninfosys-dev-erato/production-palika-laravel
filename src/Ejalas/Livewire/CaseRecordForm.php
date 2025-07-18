<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\CaseRecordAdminDto;
use Src\Ejalas\Models\CaseRecord;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\JudicialEmployee;
use Src\Ejalas\Models\JudicialMember;
use Src\Ejalas\Service\CaseRecordAdminService;
use Src\Ejalas\Models\Party;


class CaseRecordForm extends Component
{
    use SessionFlash, HelperDate;

    public ?CaseRecord $caseRecord;
    public ?Action $action;
    public $complainRegistrations;
    public $judicialMembers;
    public $complaintData = [];

    public $complainers = [];
    public $defenders = [];
    public $judicialEmployees;

    public function rules(): array
    {
        return [
            'caseRecord.complaint_registration_id' => ['required'],
            'caseRecord.discussion_date' => ['required'],
            'caseRecord.decision_date' => ['required'],
            'caseRecord.decision_authority_id' => ['required'],
            'caseRecord.recording_officer_name' => ['required'],
            'caseRecord.recording_officer_position' => ['nullable'],
            'caseRecord.remarks' => ['required'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.case-record.form");
    }

    public function mount(CaseRecord $caseRecord, Action $action)
    {
        $this->caseRecord = $caseRecord;
        $this->action = $action;

        $this->complainRegistrations = ComplaintRegistration::whereNull('deleted_at')->where('status', true)->with('parties')
            ->get()
            ->mapWithKeys(function ($complaint) {
                $partyNames = $complaint->parties->pluck('name')->implode(', '); // Get all party names as a string
                return [$complaint->id => $complaint->reg_no . ' (' . $partyNames . ')'];
            });
        if ($this->caseRecord->complaint_registration_id) {
            $this->getComplaintRegistration();
            $this->caseRecord->decision_date = replaceNumbers($this->adToBs($this->caseRecord->decision_date), true);
        }

        $this->judicialMembers = JudicialMember::where('status', true)->pluck('title', 'id');
        $this->judicialEmployees = JudicialEmployee::whereNull('deleted_at')->pluck('name', 'id');
    }
    public function getComplaintRegistration()
    {
        $complaintRegistrationId = $this->caseRecord['complaint_registration_id'];
        $this->complaintData = ComplaintRegistration::with([
            'fiscalYear',
            'priority',
            'disputeMatter',
            'parties'
        ])->find($complaintRegistrationId)?->toArray() ?? [];

        if (!empty($this->complaintData)) {
            // Access parties through the relationship
            $parties = collect($this->complaintData['parties'] ?? []);

            // Separate complainers and defenders using pivot data
            $this->complainers = $parties->filter(function ($party) {
                return $party['pivot']['type'] === 'Complainer';
            })->pluck('name')->toArray();

            $this->defenders = $parties->filter(function ($party) {
                return $party['pivot']['type'] === 'Defender';
            })->pluck('name')->toArray();
        } else {
            $this->complainers = [];
            $this->defenders = [];
        }
    }

    public function getJudicialEmployeePosition()
    {
        $judicialEmployee = JudicialEmployee::with('designation')
            ->where('id', $this->caseRecord['recording_officer_name'])
            ->first();

        if ($judicialEmployee && $judicialEmployee->designation) {
            $this->caseRecord['recording_officer_position'] = $judicialEmployee->designation->title;
        } else {
            $this->caseRecord['recording_officer_position'] = null;
        }
    }


    public function save()
    {
        $this->validate();
        try {
            $englishDate = $this->bsToAd($this->caseRecord['decision_date']);
            $this->caseRecord['decision_date'] = $englishDate;
            $dto = CaseRecordAdminDto::fromLiveWireModel($this->caseRecord);
            $service = new CaseRecordAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ejalas::ejalas.case_record_created_successfully'));
                    return redirect()->route('admin.ejalas.case_records.index');
                    break;
                case Action::UPDATE:
                    $service->update($this->caseRecord, $dto);
                    $this->successFlash(__('ejalas::ejalas.case_record_updated_successfully'));
                    return redirect()->route('admin.ejalas.case_records.index');
                    break;
                default:
                    return redirect()->route('admin.ejalas.case_records.index');
                    break;
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.')), $e->getMessage());
        }
    }
}
