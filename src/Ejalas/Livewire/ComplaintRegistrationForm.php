<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Facades\GlobalFacade;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\ComplaintRegistrationAdminDto;
use Src\Ejalas\Enum\PlaceOfRegistration;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\DisputeArea;
use Src\Ejalas\Models\DisputeMatter;
use Src\Ejalas\Models\Priotity;
use Src\Ejalas\Service\ComplaintRegistrationAdminService;
use Src\FiscalYears\Models\FiscalYear;
use Illuminate\Support\Facades\Log;
use Src\Ejalas\Models\Party;
use App\Traits\HelperDate;
use Src\Ejalas\Models\ReconciliationCenter;

class ComplaintRegistrationForm extends Component
{
    use SessionFlash, HelperDate;

    public ?ComplaintRegistration $complaintRegistration;
    public ?Action $action;
    public $showDefender;
    public $priorities;
    public $disputes;
    public $fiscalYears;
    public $reconciliationCenters;

    public $from;   //this variable checks it is from reconciliation center or general

    public array $selectedParties = [];
    public array $fetchedParties = [];
    public $placeOfRegistration;
    public $showField = false;


    protected $listeners = [
        'partyAdded' => 'addParty',
        'deleteEntryFromTable' => 'deleteParty',
    ];

    public function rules(): array
    {
        return [
            'complaintRegistration.fiscal_year_id' => ['required'],
            'complaintRegistration.reg_no' => ['required'],
            'complaintRegistration.old_reg_no' => ['nullable'],
            'complaintRegistration.reg_date' => ['required'],
            'complaintRegistration.reg_address' => ['required'],
            'complaintRegistration.complainer_id' => ['nullable'],
            'complaintRegistration.defender_id' => ['nullable'],
            'complaintRegistration.priority_id' => ['required'],
            'complaintRegistration.dispute_matter_id' => ['required'],
            'complaintRegistration.subject' => ['required'],
            'complaintRegistration.description' => ['required'],
            'complaintRegistration.claim_request' => ['required'],
            'complaintRegistration.status' => ['nullable'],
            'complaintRegistration.reconciliation_center_id' => ['nullable'],
            'complaintRegistration.reconciliation_reg_no' => [$this->showField ? 'required' : 'nullable'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.complaint-registration.form");
    }

    public function mount(ComplaintRegistration $complaintRegistration, Action $action, $from)
    {
        $this->complaintRegistration = $complaintRegistration;
        $this->action = $action;
        $this->from = $from;
        $nextId = ComplaintRegistration::max('id') + 1;
        $this->placeOfRegistration = PlaceOfRegistration::cases();


        // $this->complaintRegistration->fiscal_year_id = getSetting('fiscal-year');
        if (!$this->complaintRegistration->fiscal_year_id) {

            $this->complaintRegistration->reg_no = 'jms-' . $nextId;
        }
        $this->priorities = Priotity::whereNull('deleted_at')->pluck('name', 'id');
        $this->disputes = DisputeMatter::whereNull('deleted_at')->pluck('title', 'id');
        $this->fiscalYears = FiscalYear::whereNull('deleted_at')->pluck('year', 'id');
        $this->reconciliationCenters = ReconciliationCenter::whereNull('deleted_at')->pluck('reconciliation_center_title', 'id');
        if ($this->action === Action::UPDATE) {
            if ($this->complaintRegistration->reconciliation_reg_no) {
                $this->showField = true;
            }
            $this->complaintRegistration->reg_date = replaceNumbers($this->adToBs($this->complaintRegistration->reg_date), true);
            // Fetch parties related to this complaint registration including pivot data
            $this->selectedParties = $this->complaintRegistration
                ->parties()
                ->withPivot('type')
                ->get()
                ->map(function ($party) {
                    return [
                        'id' => $party->id,
                        'type' => $party->pivot->type,
                    ];
                })
                ->toArray();
            $this->refreshFetchedParties();
        }
    }

    public function save()
    {
        $this->validate();
        try {
            $englishDate = $this->bsToAd($this->complaintRegistration['reg_date']);
            $this->complaintRegistration['reg_date'] = $englishDate;
            $this->complaintRegistration['ward_no'] = GlobalFacade::ward();
            $dto = ComplaintRegistrationAdminDto::fromLiveWireModel($this->complaintRegistration);
            $service = new ComplaintRegistrationAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $complaint = $service->store($dto);
                    if ($complaint && isset($complaint->id)) {
                        foreach ($this->selectedParties as $party) {
                            $complaint->parties()->attach([
                                $party['id'] => ['type' => $party['type']]
                            ]);
                        }
                    }
                    break;

                case Action::UPDATE:
                    $service->update($this->complaintRegistration, $dto);
                    $this->successFlash(__('ejalas::ejalas.complaint_registration_updated_successfully'));
                    break;
            }

            // return redirect()->route(
            //     $this->from == 'reconciliationcenter' ? 'admin.ejalas.reconciliation.complaint_registrations.reconciliationIndex'
            //         : 'admin.ejalas.complaint_registrations.index'
            // );
            return redirect()->route('admin.ejalas.complaint_registrations.index', ['from' => $this->from]);
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    public function addParty($parties)
    {
        if ($this->action == Action::CREATE) {

            $this->selectedParties = collect($this->selectedParties)
                ->merge($parties)
                ->unique('id')
                ->values()
                ->toArray();
        }
        if ($this->action == Action::UPDATE) {
            foreach ($parties as $party) {
                $this->complaintRegistration->parties()->syncWithoutDetaching([
                    $party['id'] => ['type' => $party['type']]
                ]);
            }
            $this->selectedParties = $this->complaintRegistration
                ->parties()
                ->withPivot('type')
                ->get()
                ->map(function ($party) {
                    return [
                        'id' => $party->id,
                        'type' => $party->pivot->type,
                    ];
                })
                ->toArray();
        }
        $this->refreshFetchedParties();
        // Log::info('From add', ['selectedParties' => $this->selectedParties]);
    }

    public function deleteParty($partyId)
    {
        if ($this->action == Action::CREATE) {
            // Remove the party from the selectedParties array
            $this->selectedParties = array_values(array_filter($this->selectedParties, fn($party) => $party['id'] != $partyId));
        }

        if ($this->action == Action::UPDATE) {
            // Remove from pivot table
            $this->complaintRegistration->parties()->detach($partyId);
            $this->selectedParties = $this->complaintRegistration
                ->parties()
                ->withPivot('type')
                ->get()
                ->map(function ($party) {
                    return [
                        'id' => $party->id,
                        'type' => $party->pivot->type,
                    ];
                })
                ->toArray();
        }
        $this->dispatch('partyDeleted', $this->selectedParties);
        $this->successFlash(__('ejalas::ejalas.party_deleted_successfully'));
        $this->refreshFetchedParties();
    }
    public function refreshFetchedParties()
    {
        $this->dispatch('newPartyAdded', $this->selectedParties);
    }
    public function checkRegAddress()
    {
        if ($this->complaintRegistration->reg_address === PlaceOfRegistration::MEDIATION_CENTER->value) {
            $this->showField = true;
        } else {
            $this->showField = false;
        }
    }
}
