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

    public ?CourtSubmission $courtSubmission;
    public ?Action $action;
    public $complainRegistrations;
    public $complaintData = [];

    public $complainers = [];
    public $defenders = [];
    public $judicialMembers;
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

    public function mount(CourtSubmission $courtSubmission, Action $action)
    {
        $this->courtSubmission = $courtSubmission;
        $this->action = $action;
        $this->complainRegistrations = ComplaintRegistration::whereNull('deleted_at')->where('status', true)->with('parties')
            ->get()
            ->mapWithKeys(function ($complaint) {
                $partyNames = $complaint->parties->pluck('name')->implode(', '); // Get all party names as a string
                return [$complaint->id => $complaint->reg_no . ' (' . $partyNames . ')'];
            });
        if ($this->courtSubmission->complaint_registration_id) {
            $this->getComplaintRegistration();
            $this->courtSubmission->discussion_date = replaceNumbers($this->adToBs($this->courtSubmission->discussion_date), true);
        }
        $this->judicialMembers = JudicialMember::where('status', true)->pluck('title', 'id');
    }
    public function getComplaintRegistration()
    {
        $complaintRegistrationId = $this->courtSubmission['complaint_registration_id'];
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

    public function save()
    {
        $this->validate();
        try {
            $englishDate = $this->bsToAd($this->courtSubmission['discussion_date']);
            $this->courtSubmission['discussion_date'] = $englishDate;
            $dto = CourtSubmissionAdminDto::fromLiveWireModel($this->courtSubmission);
            $service = new CourtSubmissionAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ejalas::ejalas.court_submission_created_successfully'));
                    return redirect()->route('admin.ejalas.court_submissions.index');
                    break;
                case Action::UPDATE:
                    $service->update($this->courtSubmission, $dto);
                    $this->successFlash(__('ejalas::ejalas.court_submission_updated_successfully'));
                    return redirect()->route('admin.ejalas.court_submissions.index');
                    break;
                default:
                    return redirect()->route('admin.ejalas.court_submissions.index');
                    break;
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}
