<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\SettlementAdminDto;
use Src\Ejalas\DTO\SettlementDetailAdminDto;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\JudicialMember;
use Src\Ejalas\Models\Settlement;
use Src\Ejalas\Service\SettlementAdminService;
use Src\Ejalas\Service\SettlementDetailAdminService;

use Src\Ejalas\Models\Party;
use Src\Ejalas\Models\ReconciliationCenter;
use Src\Ejalas\Models\SettlementDetail;

class SettlementForm extends Component
{
    use SessionFlash, HelperDate;

    public ?Settlement $settlement;
    public ?SettlementDetail $settlementDetail;
    public ?Action $action = Action::CREATE;
    public ?Action $settlementAction = Action::CREATE;
    public $complaintRegistration;
    public $judicialMembers;
    public $reconciliationCenters;
    public $parties;

      public $showSettlementForm = false;
      protected $listeners = ['edit-settlementForm' => 'editSettlementForm','resetSettlementDetailForm'=>'resetSettlementDetailForm','editSettlementDetailForm'=>'editSettlementDetailForm'];


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
                    'settlementDetail.party_id' => ['nullable'],
        'settlementDetail.deadline_set_date' => ['nullable'],
        'settlementDetail.detail' => ['nullable'],
        ];
    }
    protected function rulesSettlementDetail(): array
{
    return [
        'settlementDetail.party_id' => ['required'],
        'settlementDetail.deadline_set_date' => ['required'],
        'settlementDetail.detail' => ['required'],
    ];
}

    public function render()
    {
        return view("Ejalas::livewire.settlement.form");
    }

    public function mount($complaintRegistration, Settlement $settlement)
    {
        $this->complaintRegistration = $complaintRegistration;
   

        $this->settlement = $settlement->exists
    ? $settlement
    : $this->getDefaultSettlement();

        $this->settlementDetail = new SettlementDetail();

        $this->reconciliationCenters = ReconciliationCenter::whereNull('deleted_at')->pluck('reconciliation_center_title', 'id');
        $this->judicialMembers = JudicialMember::whereNull('deleted_at')->pluck('title', 'id');
               $this->parties = $complaintRegistration->parties->map(fn($party) => [
    'id' => $party->id,
    'name' => $party->name,
    'type' => $party->pivot->type,
]);
    }

        public function toggleSettlementForm()
    {
        $this->showSettlementForm = !$this->showSettlementForm;

        if ($this->showSettlementForm) {
            $this->resetForm();
        }

        $this->dispatch('init-registration-date');
    }


    public function save()
    {
    
        $this->validate();
        try {
            $englishDate = $this->bsToAd($this->settlement['discussion_date']);
            $this->settlement['discussion_date_en'] = $englishDate;
            $dto = SettlementAdminDto::fromLiveWireModel($this->settlement);
            $service = new SettlementAdminService();
            switch ($this->action) {
                case Action::CREATE:
                   $service->store($dto);
                    $this->successToast(__('ejalas::ejalas.settlement_saved_successfully'));
                    break;
                case Action::UPDATE:
                    $service->update($this->settlement, $dto);
                    $this->successToast(__('ejalas::ejalas.settlement_updated_successfully'));
                    break;
            }
        $this->showSettlementForm = false;
        $this->resetForm(); // reset for next creation
      
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    public function editSettlementForm(Settlement $settlement)
    {
        $this->settlement = $settlement;
        $this->action = Action::UPDATE;
        $this->showSettlementForm = true;
        $this->dispatch('init-registration-date');
    }

    protected function resetForm()
    {
        $this->settlement = $this->getDefaultSettlement();
        $this->action = Action::CREATE;
    }

      protected function getDefaultSettlement(): Settlement
    {
        $settlement = new Settlement();
   
        $settlement->complaint_registration_id = $this->complaintRegistration->id;
    

        return $settlement;
    }
    public function saveSettlementDetail(){
       
        try {
            $this->validate($this->rulesSettlementDetail());
            $this->settlementDetail->complaint_registration_id = $this->complaintRegistration->id;
            $dto = SettlementDetailAdminDto::fromLiveWireModel($this->settlementDetail);
            $service = new SettlementDetailAdminService();
            switch ($this->settlementAction) {
                case Action::CREATE:
                   $service->store($dto);
                   $this->resetSettlementDetailForm();
                      $this->successToast(__('ejalas::ejalas.settlement_saved_successfully'));
                    break;
                case Action::UPDATE:
                    $service->update($this->settlementDetail, $dto);
                    $this->resetSettlementDetailForm();
                    $this->successToast(__('ejalas::ejalas.settlement_updated_successfully'));
                    break;
            }
        } catch (\Throwable $e) {
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    public function resetSettlementDetailForm(){
        $this->reset(['settlementDetail','settlementAction']);
        $this->settlementDetail = new SettlementDetail();
         $this->settlementAction = Action::CREATE;
         $this->dispatch('close-settlement-detail-modal');
    }
    public function editSettlementDetailForm(SettlementDetail $settlementDetail)
    {
        $this->settlementDetail = $settlementDetail;
        $this->settlementAction = Action::UPDATE;
        $this->dispatch('open-modal-settlementDetail');
    }
    
}
