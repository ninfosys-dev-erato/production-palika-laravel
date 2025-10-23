<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\CourtSubmissionAdminDto;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\CourtSubmission;
use Src\Ejalas\Service\CourtSubmissionAdminService;
use Src\Ejalas\Models\Party;
use Src\Ejalas\Models\JudicialMember;

class CourtSubmissionForm extends Component
{
    use SessionFlash, HelperDate;
    protected $listeners = ['edit-courtSubmissionForm' => 'editCourtSubmissionForm', 'courtSubmissionFormDeleted' => 'courtSubmissionFormDeleted'];


    public ?CourtSubmission $courtSubmission;
    public ?Action $action = Action::CREATE;
    public $complaintRegistration;
    public $judicialMembers;

    public bool $canAddCourtSubmission = true;

    public $showCourtSubmissionForm = false;
    public function rules(): array
    {
        return [
            'courtSubmission.complaint_registration_id' => ['required'],
            'courtSubmission.discussion_date' => ['required'],
            'courtSubmission.submission_decision_date' => ['required'],
            'courtSubmission.decision_authority_id' => ['required'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.court-submission.form");
    }

    public function mount($complaintRegistration, CourtSubmission $courtSubmission)
    {
        $this->complaintRegistration = $complaintRegistration ?? $this->getDefaultCourtSubmission();
        $this->courtSubmission = $courtSubmission;
        $exists = CourtSubmission::whereNull('deleted_at')->where('complaint_registration_id', $complaintRegistration->id)->exists();
        $this->canAddCourtSubmission = !$exists;
        $this->judicialMembers = JudicialMember::where('status', true)->pluck('title', 'id');
    }

    public function toggleCourtSubmissionForm()
    {
        $this->showCourtSubmissionForm = !$this->showCourtSubmissionForm;

        if ($this->showCourtSubmissionForm) {
            $this->resetForm();
        }

        $this->dispatch('init-registration-date');
    }


    public function save()
    {
        $this->validate();
        try {
            $englishDate = $this->bsToAd($this->courtSubmission['discussion_date']);
            $this->courtSubmission['discussion_date_en'] = $englishDate;
            $dto = CourtSubmissionAdminDto::fromLiveWireModel($this->courtSubmission);
            $service = new CourtSubmissionAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->canAddCourtSubmission = false;
                    $this->successToast(__('ejalas::ejalas.court_submission_created_successfully'));
                    break;
                case Action::UPDATE:
                    $service->update($this->courtSubmission, $dto);
                    $this->successToast(__('ejalas::ejalas.court_submission_updated_successfully'));
                    break;
                default:
                    break;
            }
            $this->showCourtSubmissionForm = false;
            $this->resetForm(); // reset for next creation
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
    public function editCourtSubmissionForm(CourtSubmission $courtSubmission)
    {
        $this->courtSubmission = $courtSubmission;
        $this->action = Action::UPDATE;
        $this->showCourtSubmissionForm = true;
        $this->dispatch('init-registration-date');
    }


    protected function resetForm()
    {
        $this->courtSubmission = $this->getDefaultCourtSubmission();
        $this->action = Action::CREATE;
    }


    protected function getDefaultCourtSubmission(): CourtSubmission
    {


        $courtSubmission = new CourtSubmission();
        $courtSubmission->complaint_registration_id = $this->complaintRegistration->id;


        return $courtSubmission;
    }
    public function courtSubmissionFormDeleted()
    {
        $this->canAddCourtSubmission = true;
    }
}
