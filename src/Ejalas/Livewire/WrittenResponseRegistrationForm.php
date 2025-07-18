<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\WrittenResponseRegistrationAdminDto;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\WrittenResponseRegistration;
use Src\Ejalas\Service\WrittenResponseRegistrationAdminService;
use Src\Ejalas\Models\Party;
use Src\Ejalas\Enum\PartyType;
use Src\Ejalas\Models\RegistrationIndicator;

class WrittenResponseRegistrationForm extends Component
{
    use SessionFlash;

    public ?WrittenResponseRegistration $writtenResponseRegistration;
    public ?Action $action;
    public $complainRegistrations;
    public $complaintData = [];

    public $complainers = [];
    public $defenders = [];
    public $registrationIndicators;
    public array $selectedIndicators = []; //stores data in the json format



    public function rules(): array
    {
        return [
            'writtenResponseRegistration.response_registration_no' => ['required'],
            'writtenResponseRegistration.complaint_registration_id' => ['required'],
            'writtenResponseRegistration.registration_date' => ['required'],
            'writtenResponseRegistration.fee_amount' => ['required'],
            'writtenResponseRegistration.fee_receipt_no' => ['required'],
            'writtenResponseRegistration.fee_paid_date' => ['required'],
            'writtenResponseRegistration.description' => ['required'],
            'writtenResponseRegistration.claim_request' => ['required'],
            'writtenResponseRegistration.submitted_within_deadline' => ['nullable'],
            'writtenResponseRegistration.fee_receipt_attached' => ['nullable'],
            'writtenResponseRegistration.status' => ['required'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.written-response-registration.form");
    }

    public function mount(WrittenResponseRegistration $writtenResponseRegistration, Action $action)
    {
        $this->writtenResponseRegistration = $writtenResponseRegistration;
        $this->action = $action;
        $nextId = WrittenResponseRegistration::max('id') + 1;
        $this->writtenResponseRegistration->response_registration_no = $nextId;

        $this->registrationIndicators = RegistrationIndicator::whereNull('deleted_at')->where('indicator_type', PartyType::Defender)->pluck('dispute_title', 'id');

        $this->complainRegistrations = ComplaintRegistration::whereNull('deleted_at')->where('status', true)->with('parties')
            ->get()
            ->mapWithKeys(function ($complaint) {
                $partyNames = $complaint->parties->pluck('name')->implode(', '); // Get all party names as a string
                return [$complaint->id => $complaint->reg_no . ' (' . $partyNames . ')'];
            });
        if ($this->writtenResponseRegistration->complaint_registration_id) {
            $this->getComplaintRegistration();
            $this->selectedIndicators = json_decode($this->writtenResponseRegistration->registration_indicator, true);
        }
    }
    public function getComplaintRegistration()
    {
        $complaintRegistrationId = $this->writtenResponseRegistration['complaint_registration_id'];
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
    public function updatedSelectedIndicators($value)
    {
        if (in_array('पूरा नभएको', $this->selectedIndicators)) {
            $this->writtenResponseRegistration['status'] = "Rejected";
        } else {
            $this->writtenResponseRegistration['status'] = "Approved";
        }
    }

    public function save()
    {
        $this->validate();
        try {
            $this->writtenResponseRegistration->registration_indicator = json_encode($this->selectedIndicators, JSON_UNESCAPED_UNICODE);
            $dto = WrittenResponseRegistrationAdminDto::fromLiveWireModel($this->writtenResponseRegistration);
            $service = new WrittenResponseRegistrationAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ejalas::ejalas.written_response_registration_created_successfully'));
                    return redirect()->route('admin.ejalas.written_response_registrations.index');
                    break;
                case Action::UPDATE:
                    $service->update($this->writtenResponseRegistration, $dto);
                    $this->successFlash(__('ejalas::ejalas.written_response_registration_updated_successfully'));
                    return redirect()->route('admin.ejalas.written_response_registrations.index');
                    break;
                default:
                    return redirect()->route('admin.ejalas.written_response_registrations.index');
                    break;
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}
