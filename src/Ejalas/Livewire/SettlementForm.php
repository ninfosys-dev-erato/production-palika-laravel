<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\SettlementAdminDto;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\JudicialMember;
use Src\Ejalas\Models\Settlement;
use Src\Ejalas\Service\SettlementAdminService;
use Src\Ejalas\Models\Party;
use Src\Ejalas\Models\ReconciliationCenter;
use Src\Ejalas\Models\SettlementDetail;

class SettlementForm extends Component
{
    use SessionFlash, HelperDate;

    public ?Settlement $settlement;
    public ?Action $action;
    public $complainRegistrations;
    public $complaintData = [];

    public $complainers = [];
    public $defenders = [];
    public $parties = [];

    public $judicialMembers;
    protected $listeners = ['clearInputFields'];

    //to save settlement detail temporary
    public $temporaryDetails = [];
    public $settlementDetail = [
        'party_id' => '',
        'deadline_set_date' => '',
        'detail' => '',
        'party_name' => '',
        'complaint_registration_id' => '',
    ];
    public $editIndex = null;
    public $from;
    public $reconciliationCenters;

    public function rules(): array
    {
        return [
            'settlement.complaint_registration_id' => ['required'],
            'settlement.discussion_date' => ['required'],
            'settlement.settlement_date' => ['required'],
            'settlement.present_members' => ['nullable'],
            'settlement.settlement_details' => ['required'],
            'settlement.is_settled' => ['nullable'],
            'settlement.reconciliation_center_id' => ['nullable'],
        ];
    }
    public function render()
    {
        return view("Ejalas::livewire.settlement.form");
    }

    public function mount(Settlement $settlement, Action $action, $from = null)
    {
        $this->settlement = $settlement;
        $this->action = $action;
        $this->from = $from;
        $this->reconciliationCenters = ReconciliationCenter::whereNull('deleted_at')->pluck('reconciliation_center_title', 'id');
        $this->complainRegistrations = ComplaintRegistration::whereNull('deleted_at')->where('status', true)->with('parties')
            ->get()
            ->mapWithKeys(function ($complaint) {
                $partyNames = $complaint->parties->pluck('name')->implode(', ');
                return [$complaint->id => $complaint->reg_no . ' (' . $partyNames . ')'];
            });
        // $this->complainRegistrations = ComplaintRegistration::whereNull('deleted_at')->where('status', true)->pluck('reg_no', 'id');
        $this->judicialMembers = JudicialMember::whereNull('deleted_at')->pluck('title', 'id');
        if ($this->settlement->complaint_registration_id) {
            $this->getComplaintRegistration();
        }

        if ($this->action === Action::UPDATE) { //load settlement details if it is updating
            $this->loadSettlementDetails();
            $this->settlement->discussion_date = replaceNumbers($this->adToBs($this->settlement->discussion_date), true);
        }
    }

    public function getComplaintRegistration()
    {
        $complaintRegistrationId = $this->settlement['complaint_registration_id'];
        $complaintData = ComplaintRegistration::with(['parties'])->find($complaintRegistrationId);

        if ($complaintData) {

            $this->parties = $complaintData->parties;
        } else {
            $this->parties = [];
        }
        // Reset the form after changing complaint registration number
        $this->temporaryDetails = [];
    }

    public function save()
    {
        $this->validate();
        try {
            $englishDate = $this->bsToAd($this->settlement['discussion_date']);
            $this->settlement['discussion_date'] = $englishDate;
            $dto = SettlementAdminDto::fromLiveWireModel($this->settlement);
            $service = new SettlementAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $settlement = $service->store($dto);
                    $this->storeSettlementDetails($settlement);
                    break;
                case Action::UPDATE:
                    $service->update($this->settlement, $dto);
                    $this->storeSettlementDetails($this->settlement);
                    $this->successFlash(__('ejalas::ejalas.settlement_updated_successfully'));
                    break;
            }
            return redirect()->route('admin.ejalas.settlements.index', ['from' => $this->from]);
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    public function saveTemporaryDetail()
    {
        $this->validate([
            'settlementDetail.party_id' => 'required',
            'settlementDetail.deadline_set_date' => 'required',
            'settlementDetail.detail' => 'required',
        ]);


        $this->settlementDetail['complaint_registration_id'] = $this->settlement['complaint_registration_id'];
        $selectedParty = collect($this->parties)->firstWhere('id', $this->settlementDetail['party_id']);
        $this->settlementDetail['party_name'] = $selectedParty?->name ?? ''; //adds name to the array 
        // Check if we're editing an existing detail
        if ($this->editIndex !== null) {
            // Update the existing detail
            $this->temporaryDetails[$this->editIndex] = $this->settlementDetail;
            $this->editIndex = null;
        } else {
            $this->temporaryDetails[] = $this->settlementDetail; //add new settlement detail
        }
        // Reset the form after saving
        $this->settlementDetail = [
            'party_id' => '',
            'deadline_set_date' => '',
            'detail' => '',
            'party_name' => '',
            'complaint_registration_id' => '',
        ];
        $this->dispatch('close-modal');
        $this->successFlash(__('ejalas::ejalas.settlement_detail_saved_successfully'));
    }

    public function editTemporaryDetail($index)
    {
        $this->editIndex = $index;

        $this->settlementDetail = $this->temporaryDetails[$index];

        $this->dispatch('open-modal');
    }
    public function removeTemporaryDetail($index)
    {
        unset($this->temporaryDetails[$index]);
        $this->temporaryDetails = array_values($this->temporaryDetails); // Reindex
        $this->successFlash(__('ejalas::ejalas.settlement_detail_deleted_successfully'));
    }
    private function storeSettlementDetails(Settlement $settlement)
    {
        // Clear existing details if updating
        SettlementDetail::where('settlement_id', $settlement->id)->delete(); // deleted at updated

        foreach ($this->temporaryDetails as $detail) {
            SettlementDetail::create([
                'settlement_id' => $settlement->id,
                'party_id' => $detail['party_id'],
                'deadline_set_date' => $detail['deadline_set_date'],
                'detail' => $detail['detail'],
                'complaint_registration_id' => $detail['complaint_registration_id'],
                'is_settled' => $this->settlement?->is_settled ?? false,
            ]);
        }
    }
    public function loadSettlementDetails()
    {
        $this->temporaryDetails = SettlementDetail::where('settlement_id', $this->settlement->id)
            ->get()
            ->map(function ($detail) {
                return [
                    'party_id' => $detail->party_id,
                    'party_name' => Party::find($detail->party_id)->name ?? 'N/A',
                    'deadline_set_date' => $detail->deadline_set_date,
                    'detail' => $detail->detail,
                    'complaint_registration_id' => $detail->complaint_registration_id,
                ];
            })
            ->toArray();
    }
    public function resetForm()
    {
        $this->settlementDetail = [
            'party_id' => null,
            'deadline_set_date' => null,
            'detail' => null,
        ];
        // $this->editIndex = null;
        $this->resetErrorBag();
    }
}
