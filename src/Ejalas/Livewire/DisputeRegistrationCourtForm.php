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
use  Src\Ejalas\Enum\ApplicationStatus;

class DisputeRegistrationCourtForm extends Component
{
    use SessionFlash;

    public ?DisputeRegistrationCourt $disputeRegistrationCourt;
    public ?Action $action = Action::CREATE;
    public $complaintRegistration;
    public $registerEmployees;
    public bool $conditionsChecked = false;
    public bool $showForm;

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


    public function mount(ComplaintRegistration $complaintRegistration)
    {
        $this->complaintRegistration = $complaintRegistration;

$this->disputeRegistrationCourt =DisputeRegistrationCourt::with('judicialEmployee')->firstOrNew([
    'complaint_registration_id' => $complaintRegistration->id,
]);


        $this->registrationIndicators = RegistrationIndicator::whereNull('deleted_at')->where('indicator_type', PartyType::Complainer)->pluck('dispute_title', 'id');
 

        if ($this->complaintRegistration->status == ApplicationStatus::Pending) {
            $this->showForm = true;
            $this->action = Action::CREATE;
            $this->disputeRegistrationCourt['status'] = 'rejected';
        } else {
            $this->showForm= false;

            $this->selectedIndicators = json_decode($this->disputeRegistrationCourt->registration_indicator ?? '[]', true) ?? [];

        }
        $this->registerEmployees = JudicialEmployee::whereNull('deleted_at')->pluck('name', 'id');
    }
  
    public function updatedSelectedIndicators()
    {
        if (in_array('पूरा नभएको', $this->selectedIndicators)) {
            $this->disputeRegistrationCourt['status'] = 'rejected';
        } else {
            $this->disputeRegistrationCourt['status'] = 'approved';
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
                    $this->successToast(__('ejalas::ejalas.dispute_registration_court_created_successfully'));
                     $this->showForm= false;
                    // return redirect()->route('admin.ejalas.dispute_registration_courts.index');
                    break;

                case Action::UPDATE:
                    $service->update($this->disputeRegistrationCourt, $dto);
                    $this->successToast(__('ejalas::ejalas.dispute_registration_court_updated_successfully'));
                     $this->showForm= false;
                    // return redirect()->route('admin.ejalas.dispute_registration_courts.index');
                    break;

                default:
                    // return redirect()->route('admin.ejalas.dispute_registration_courts.index');
                    break;
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    public function print()
    {
        // Redirect to print route or generate PDF
        // return redirect()->route('admin.ejalas.dispute_registration_courts.print', ['id' => $this->disputeRegistrationCourt->id]);
    }

    public function edit()
    {
        $this->showForm = true;
        $this->action = Action::UPDATE;
         $this->dispatch('init-registration-date');

    }
}
