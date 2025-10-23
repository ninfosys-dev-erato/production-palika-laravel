<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Src\Ejalas\DTO\FulfilledConditionAdminDto;
use Src\Ejalas\Enum\PartyType;
use Src\Ejalas\Models\FulfilledCondition;
use Src\Ejalas\Service\FulfilledConditionAdminService;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\JudicialEmployee;
use Src\Ejalas\Models\JudicialMember;
use Src\Ejalas\Models\Party;
use Src\Ejalas\Models\SettlementDetail;

class FulfilledConditionForm extends Component
{
    use SessionFlash, HelperDate;

    public ?FulfilledCondition $fulfilledCondition;
    public ?Action $action = Action::CREATE;
    public $complaintRegistration;
    public $conditions = [];
    public $judicialEmployees;
    public $allSettlementDetails = [];
    public $parties;

    public $showFulfilledConditionForm = false;
    protected $listeners = ['edit-fulFilledConditionForm' => 'editFulFilledConditionForm'];


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
            'fulfilledCondition.entered_by' => ['required'],
            'fulfilledCondition.entry_date' => ['required'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.fulfilled-condition.form");
    }

    public function mount($complaintRegistration, FulfilledCondition $fulfilledCondition)
    {
        $this->complaintRegistration = $complaintRegistration;
        $this->fulfilledCondition = $fulfilledCondition ?? $this->getDefaultFulfilledCondition();

        $this->judicialEmployees = JudicialEmployee::whereNull('deleted_at')->pluck('name', 'id');
        $this->parties = $complaintRegistration->parties->map(fn($party) => [
            'id' => $party->id,
            'name' => $party->name,
            'type' => $party->pivot->type,
        ]);
        $this->getAllSettlementDetails();
    }

    public function toggleFulFilledConditionForm()
    {
        $this->showFulfilledConditionForm = !$this->showFulfilledConditionForm;

        if ($this->showFulfilledConditionForm) {
            $this->resetForm();
        }
        $this->dispatch('init-registration-date');
    }

    public function getCondition()
    {
        $currentConditionId = $this->fulfilledCondition['condition'] ?? null;

        $this->conditions = SettlementDetail::whereNull('deleted_at')->where('complaint_registration_id', $this->fulfilledCondition->complaint_registration_id)
            ->where('party_id', $this->fulfilledCondition->fulfilling_party)
            ->where(function ($query) use ($currentConditionId) {
                $query->where(function ($q) {
                    $q->where('is_settled', false)
                        ->orWhereNull('is_settled');
                });

                if ($currentConditionId) {
                    $query->orWhere('id', $currentConditionId);
                }
            })
            ->get();
    }


    public function getAllSettlementDetails()
    {
        $partyMap = $this->parties->keyBy('id');

        $this->allSettlementDetails = SettlementDetail::whereNull('deleted_at')->where('complaint_registration_id', $this->complaintRegistration->id)
            ->get()
            ->map(fn($detail) => [
                'party_id' => $partyMap[$detail->party_id] ?? null,
                'settlementparty_id' => $detail->party_id,
                'type' => $partyMap[$detail->party_id]['type'] ?? 'Unknown',
                'detail' => $detail->detail ?? 'N/A',
                'status' => $detail->is_settled ?? false,
                'party_name' => $partyMap[$detail->party_id]['name'] ?? 'N/A',
            ])
            ->groupBy('type');
    }





    public function getDeadline()
    {
        $conditionId = $this->fulfilledCondition->condition;


        $deadline = SettlementDetail::where('id', $conditionId)->value('deadline_set_date');

        $this->fulfilledCondition->due_date = $deadline;
    }

    public function save()
    {
        $this->validate();
        try {
            $bsDate = $this->fulfilledCondition['entry_date'];
            $englishDate = $this->bsToAd($bsDate);
            $this->fulfilledCondition['entry_date_en'] = $englishDate;
            $dto = FulfilledConditionAdminDto::fromLiveWireModel($this->fulfilledCondition);


            $service = new FulfilledConditionAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successToast(__('ejalas::ejalas.fulfilled_condition_created_successfully'));
                    break;
                case Action::UPDATE:
                    $service->update($this->fulfilledCondition, $dto);
                    $this->successToast(__('ejalas::ejalas.fulfilled_condition_updated_successfully'));
                    break;
                default:
                    break;
            }
            $this->showFulfilledConditionForm = false;
            $this->getAllSettlementDetails();
            $this->resetForm(); // reset for next creation
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
    public function editFulFilledConditionForm(FulfilledCondition $fulfilledCondition)
    {
        $this->fulfilledCondition = $fulfilledCondition;
        $this->action = Action::UPDATE;
        $this->showFulfilledConditionForm = true;
        $this->dispatch('init-registration-date');
    }

    protected function resetForm()
    {
        $this->fulfilledCondition = $this->getDefaultFulfilledCondition();
        $this->action = Action::CREATE;
    }


    protected function getDefaultFulfilledCondition(): FulfilledCondition
    {


        $fulfilledCondition = new FulfilledCondition();
        $fulfilledCondition->complaint_registration_id = $this->complaintRegistration->id;


        return $fulfilledCondition;
    }
}
