<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\DisputeRegistrationCourtAdminDto;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\DisputeRegistrationCourt;
use Src\Ejalas\Models\Party;
use Src\Ejalas\Service\DisputeRegistrationCourtAdminService;
use Illuminate\Support\Facades\DB;
use Src\Ejalas\Enum\PartyType;
use Src\Ejalas\Models\RegistrationIndicator;
use Src\Ejalas\Models\JudicialEmployee;

class DisputeRegistrationCourtForm extends Component
{
    use SessionFlash;

    public ?DisputeRegistrationCourt $disputeRegistrationCourt;
    public ?Action $action;
    public $complainRegistrations;
    public array $disputeConditions = [];
    public $registerEmployees;
    public bool $conditionsChecked = false;
    public array $complaintData = [];

    public array $complainers = [];
    public array $defenders = [];
    public $registrationIndicators;
    public array $selectedIndicators = []; //stores data in the json format

    public function rules(): array
    {
        return [
            'disputeRegistrationCourt.complaint_registration_id' => ['required'],
            'disputeRegistrationCourt.registrar_id' => ['required'],
            'disputeRegistrationCourt.status' => ['required'],
            'disputeRegistrationCourt.is_details_provided' => ['nullable'],
            'disputeRegistrationCourt.decision_date' => ['required'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.dispute-registration-court.form");
    }

    public function mount(DisputeRegistrationCourt $disputeRegistrationCourt, Action $action)
    {
        $this->disputeRegistrationCourt = $disputeRegistrationCourt;
        $this->action = $action;

        $this->registrationIndicators = RegistrationIndicator::whereNull('deleted_at')->where('indicator_type', PartyType::Complainer)->pluck('dispute_title', 'id');
        if ($this->disputeRegistrationCourt->exists) {
            $this->complainRegistrations = ComplaintRegistration::whereNull('deleted_at')
                ->with('parties')
                ->get()
                ->mapWithKeys(function ($complaint) {
                    $partyNames = $complaint->parties->pluck('name')->implode(', '); // Get all party names as a string
                    return [$complaint->id => $complaint->reg_no . ' (' . $partyNames . ')'];
                });
            $this->selectedIndicators = json_decode($this->disputeRegistrationCourt->registration_indicator, true);
        } else {
            $this->complainRegistrations = ComplaintRegistration::whereNull('deleted_at')
                ->whereNull('status')
                ->with('parties')
                ->get()
                ->mapWithKeys(function ($complaint) {
                    $partyNames = $complaint->parties->pluck('name')->implode(', '); // Get all party names as a string
                    return [$complaint->id => $complaint->reg_no . ' (' . $partyNames . ')'];
                });

            $this->disputeRegistrationCourt['status'] = 'Rejected';
        }


        $this->registerEmployees = JudicialEmployee::whereNull('deleted_at')->pluck('name', 'id');
    }
    //Hook function updated DisputeRegistrationCourtIsDetailsProvided (bool)
    public function updatedSelectedIndicators($value)
    {
        if (in_array('पूरा नभएको', $this->selectedIndicators)) {
            $this->disputeRegistrationCourt['status'] = 'Rejected';
        } else {
            $this->disputeRegistrationCourt['status'] = 'Approved';
        }
    }




    public function getComplaintRegistration()
    {
        $complaintRegistrationId = $this->disputeRegistrationCourt['complaint_registration_id'];

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
            $this->disputeRegistrationCourt->registration_indicator = json_encode($this->selectedIndicators, JSON_UNESCAPED_UNICODE);

            $dto = DisputeRegistrationCourtAdminDto::fromLiveWireModel($this->disputeRegistrationCourt);
            $service = new DisputeRegistrationCourtAdminService();

            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ejalas::ejalas.dispute_registration_court_created_successfully'));
                    return redirect()->route('admin.ejalas.dispute_registration_courts.index');
                    break;

                case Action::UPDATE:
                    $service->update($this->disputeRegistrationCourt, $dto);
                    $this->successFlash(__('ejalas::ejalas.dispute_registration_court_updated_successfully'));
                    return redirect()->route('admin.ejalas.dispute_registration_courts.index');
                    break;

                default:
                    return redirect()->route('admin.ejalas.dispute_registration_courts.index');
                    break;
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}
