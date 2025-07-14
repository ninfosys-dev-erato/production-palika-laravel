<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Src\Ejalas\DTO\FulfilledConditionAdminDto;
use Src\Ejalas\Models\FulfilledCondition;
use Src\Ejalas\Service\FulfilledConditionAdminService;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\JudicialMember;
use Src\Ejalas\Models\Party;
use Src\Ejalas\Models\SettlementDetail;

class FulfilledConditionForm extends Component
{
    use SessionFlash, HelperDate;

    public ?FulfilledCondition $fulfilledCondition;
    public ?Action $action;
    public $complainRegistrations;

    public $parties = [];
    public $conditions = [];
    public $judicialMembers;
    public $allSettlementDetails;
    public $from;

    public function rules(): array
    {
        return [
            'fulfilledCondition.complaint_registration_id' => ['required'],
            'fulfilledCondition.fulfilling_party' => ['required'],
            'fulfilledCondition.condition' => ['required'],
            'fulfilledCondition.completion_details' => ['required'],
            'fulfilledCondition.completion_proof' => ['required'],
            'fulfilledCondition.due_date' => ['required'],
            'fulfilledCondition.completion_date' => ['required'],
            'fulfilledCondition.entered_by' => ['nullable'],
            'fulfilledCondition.entry_date' => ['required'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.fulfilled-condition.form");
    }

    public function mount(FulfilledCondition $fulfilledCondition, Action $action, $from)
    {
        $this->fulfilledCondition = $fulfilledCondition;
        $this->action = $action;
        $this->from = $from;

        $this->complainRegistrations = ComplaintRegistration::whereNull('deleted_at')->where('status', true)->with('parties')
            ->get()
            ->mapWithKeys(function ($complaint) {
                $partyNames = $complaint->parties->pluck('name')->implode(', ');
                return [$complaint->id => $complaint->reg_no . ' (' . $partyNames . ')'];
            });
        $this->judicialMembers = JudicialMember::whereNull('deleted_at')->pluck('title', 'id');

        if ($action === Action::UPDATE) {
            $this->getComplaintRegistration(); // fetch parties
            $this->getCondition();             // fetch conditions
            $this->fulfilledCondition->entry_date =  replaceNumbers($this->adToBs($this->fulfilledCondition->entry_date), true);
        }
    }
    public function getComplaintRegistration()
    {
        $complaintRegistrationId = $this->fulfilledCondition['complaint_registration_id'];
        $complaintregistrationdetail = ComplaintRegistration::find($complaintRegistrationId);
        if (!empty($complaintRegistrationId)) {
            $this->parties = $complaintregistrationdetail->parties;

            // $this->allSettlementDetails = SettlementDetail::with('party')
            //     ->join('complaint_party', 'jms_settlement_details.party_id', '=', 'complaint_party.party_id')
            //     ->select('jms_settlement_details.*', 'complaint_party.type')
            //     ->where('jms_settlement_details.complaint_registration_id', $this->fulfilledCondition['complaint_registration_id'])
            //     ->whereColumn('jms_settlement_details.complaint_registration_id', 'complaint_party.complaint_id')
            //     ->get()
            //     ->groupBy('type');
            $this->allSettlementDetails = DB::table('jms_settlement_details')
                ->join('complaint_party', 'jms_settlement_details.party_id', '=', 'complaint_party.party_id')
                ->select('jms_settlement_details.*', 'complaint_party.type')
                ->where('jms_settlement_details.complaint_registration_id', $this->fulfilledCondition['complaint_registration_id'])
                ->whereColumn('jms_settlement_details.complaint_registration_id', 'complaint_party.complaint_id')
                ->get()
                ->groupBy('type');
            // dd($this->allSettlementDetails);
        }
    }
    public function getCondition()
    {
        $currentConditionId = $this->fulfilledCondition['condition'] ?? null;

        $this->conditions = SettlementDetail::where('complaint_registration_id', $this->fulfilledCondition['complaint_registration_id'])
            ->where('party_id', $this->fulfilledCondition['fulfilling_party'])
            ->where(function ($query) use ($currentConditionId) {
                $query->where('is_settled', false);
                if ($currentConditionId) {
                    $query->orWhere('id', $currentConditionId);
                }
            })
            ->get();

        // $this->conditions = SettlementDetail::where('complaint_registration_id', $this->fulfilledCondition['complaint_registration_id'])
        //     ->where('party_id', $this->fulfilledCondition['fulfilling_party'])
        //     ->where(function ($query) use ($currentConditionId) {
        //         $query->whereNotIn('id', function ($subquery) {
        //             $subquery->select('condition')
        //                 ->from('jms_fulfilled_conditions')
        //                 ->whereNull('deleted_at');
        //         });
        //         if ($currentConditionId) {
        //             $query->orWhere('id', $currentConditionId);
        //         }
        //     })
        //     ->get();
    }

    public function getDeadline()
    {
        $conditionId = $this->fulfilledCondition['condition'];


        $deadline = SettlementDetail::where('id', $conditionId)->value('deadline_set_date');

        $this->fulfilledCondition['due_date'] = $deadline;
    }

    public function save()
    {
        $this->validate();
        try {
            $bsDate = $this->fulfilledCondition['entry_date'];
            $englishDate = $this->bsToAd($bsDate);
            $this->fulfilledCondition['entry_date'] = $englishDate;
            $dto = FulfilledConditionAdminDto::fromLiveWireModel($this->fulfilledCondition);

            $service = new FulfilledConditionAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ejalas::ejalas.fulfilled_condition_created_successfully'));
                    return redirect()->route('admin.ejalas.fulfilled_conditions.index', ['from' => $this->from]);
                    break;
                case Action::UPDATE:
                    $service->update($this->fulfilledCondition, $dto);
                    $this->successFlash(__('ejalas::ejalas.fulfilled_condition_updated_successfully'));
                    return redirect()->route('admin.ejalas.fulfilled_conditions.index', ['from' => $this->from]);
                    break;
                default:
                    return redirect()->route('admin.ejalas.fulfilled_conditions.index', ['from' => $this->from]);
                    break;
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}
