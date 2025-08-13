<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\DisputeDeadlineAdminDto;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\DisputeDeadline;
use Src\Ejalas\Models\JudicialEmployee;
use Src\Ejalas\Service\DisputeDeadlineAdminService;
use Src\Ejalas\Models\Party;
use App\Traits\HelperDate;

class DisputeDeadlineForm extends Component
{
    use SessionFlash, HelperDate;

    public ?DisputeDeadline $disputeDeadline;
    public ?Action $action;
    public $complainRegistrations;
    public $registerEmployees;
    public $complaintData = [];

    public $complainers = [];
    public $defenders = [];

    public function rules(): array
    {
        return [
            'disputeDeadline.complaint_registration_id' => ['required'],
            'disputeDeadline.registrar_id' => ['required'],
            'disputeDeadline.deadline_set_date' => ['required'],
            'disputeDeadline.deadline_extension_period' => ['required', 'numeric', 'min:1'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.dispute-deadline.form");
    }

    public function mount(DisputeDeadline $disputeDeadline, Action $action)
    {
        $this->disputeDeadline = $disputeDeadline;
        $this->action = $action;
        $this->complainRegistrations = ComplaintRegistration::whereNull('deleted_at')->where('status', true)
            ->with('parties')
            ->get()
            ->mapWithKeys(function ($complaint) {
                $partyNames = $complaint->parties->pluck('name')->implode(', '); // Get all party names as a string
                return [$complaint->id => $complaint->reg_no . ' (' . $partyNames . ')'];
            });



        $this->registerEmployees = JudicialEmployee::whereNull('deleted_at')->pluck('name', 'id');
        if ($this->disputeDeadline->complaint_registration_id) {
            $this->getComplaintRegistration();
            $this->disputeDeadline->deadline_set_date =  replaceNumbers($this->adToBs($this->disputeDeadline->deadline_set_date), true);
        }
    }

    public function getComplaintRegistration()
    {
        $complaintRegistrationId = $this->disputeDeadline['complaint_registration_id'];

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
            $bsDate = $this->disputeDeadline['deadline_set_date'];
            $englishDate = $this->bsToAd($bsDate);
            $this->disputeDeadline['deadline_set_date'] = $englishDate;

            $dto = DisputeDeadlineAdminDto::fromLiveWireModel($this->disputeDeadline);
            $service = new DisputeDeadlineAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ejalas::ejalas.dispute_deadline_created_successfully'));
                    return redirect()->route('admin.ejalas.dispute_deadlines.index');
                    break;
                case Action::UPDATE:
                    $service->update($this->disputeDeadline, $dto);
                    $this->successFlash(__('ejalas::ejalas.dispute_deadline_updated_successfully'));
                    return redirect()->route('admin.ejalas.dispute_deadlines.index');
                    break;
                default:
                    return redirect()->route('admin.ejalas.dispute_deadlines.index');
                    break;
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}
