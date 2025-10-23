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
    public ?Action $action = Action::CREATE;
    public $complaintRegistration;
    public $judicialMembers;
    public $judicialEmployees;
        public $showCaseRecordForm = false;
           public bool $canCaseRecord = true;
        
               protected $listeners = ['edit-caseRecordForm' => 'editCaseRecordForm','caseRecordDeleted'=>'caseRecordDeleted'];


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

    public function mount($complaintRegistration, CaseRecord $caseRecord)
    {
        $this->complaintRegistration = $complaintRegistration;
        $this->caseRecord = $caseRecord ?? $this->getDefaultCaseRecord();
        
        $this->judicialMembers = JudicialMember::where('status', true)->pluck('title', 'id');
        $this->judicialEmployees = JudicialEmployee::whereNull('deleted_at')->pluck('name', 'id');
             $exists = CaseRecord::whereNull('deleted_at')->where('complaint_registration_id', $complaintRegistration->id)->exists();
    $this->canCaseRecord = !$exists;
    }

       public function toggleCaseRecordForm()
    {
        $this->showCaseRecordForm = !$this->showCaseRecordForm;

        if ($this->showCaseRecordForm) {
            $this->resetForm();
        }

        $this->dispatch('init-registration-date');
    }


    public function save()
    {
        $this->validate();
        try {
            $englishDate = $this->bsToAd($this->caseRecord['decision_date']);
            $this->caseRecord['decision_date_en'] = $englishDate;
            $dto = CaseRecordAdminDto::fromLiveWireModel($this->caseRecord);
            $service = new CaseRecordAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                         $this->canCaseRecord = false;
                    $this->successToast(__('ejalas::ejalas.case_record_created_successfully'));
                    break;
                case Action::UPDATE:
                    $service->update($this->caseRecord, $dto);
                    $this->successToast(__('ejalas::ejalas.case_record_updated_successfully'));
                    break;
                default:
                    break;
            }
                 $this->showCaseRecordForm = false;
        $this->resetForm(); // reset for next creation
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.')), $e->getMessage());
        }
    }

        public function editCaseRecordForm(CaseRecord $caseRecord)
    {
        $this->caseRecord = $caseRecord;
        $this->action = Action::UPDATE;
        $this->showCaseRecordForm = true;
        $this->dispatch('init-registration-date');
    }

    protected function resetForm()
    {
        $this->caseRecord = $this->getDefaultCaseRecord();
        $this->action = Action::CREATE;
    }

 
    protected function getDefaultCaseRecord(): CaseRecord
    {


        $caseRecord = new CaseRecord();
        $caseRecord->complaint_registration_id = $this->complaintRegistration->id;
    

        return $caseRecord;
    }
       public function caseRecordDeleted(){
            $this->canCaseRecord = true;
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

}
