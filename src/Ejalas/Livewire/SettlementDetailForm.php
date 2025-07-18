<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;

use Src\Ejalas\DTO\SettlementDetailAdminDto;
use Src\Ejalas\Models\SettlementDetail;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\JudicialMember;
use Src\Ejalas\Models\Party;
use Src\Ejalas\Service\SettlementDetailAdminService;

class SettlementDetailForm extends Component
{
    use SessionFlash;

    public ?SettlementDetail $settlementDetail;
    public ?Action $action;
    public $complainRegistrations;
    public $judicialMembers;
    public $complaintData = [];

    public $complainers = [];
    public $defenders = [];
    public bool $temporary;

    public function rules(): array
    {
        return [
            'settlementDetail.complaint_registration_id' => ['required'],
            'settlementDetail.party_id' => ['required'],
            'settlementDetail.deadline_set_date' => ['required'],
            'settlementDetail.detail' => ['required'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.settlement-detail.form");
    }

    public function mount(SettlementDetail $settlementDetail, Action $action, bool $temporary = false)
    {
        $this->settlementDetail = $settlementDetail;
        $this->action = $action;
        $this->temporary = $temporary;
    }



    public function save()
    {

        $this->validate();
        try {
            $dto = SettlementDetailAdminDto::fromLiveWireModel($this->settlementDetail);
            $service = new SettlementDetailAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ejalas::ejalas.settlement_detail_created_successfully'));
                    return redirect()->route('admin.ejalas.settlement_details.index');
                    break;
                case Action::UPDATE:
                    $service->update($this->caseRecord, $dto);
                    $this->successFlash(__('ejalas::ejalas.settlement_detail_updated_successfully'));
                    return redirect()->route('admin.ejalas.settlement_details.index');
                    break;
                default:
                    return redirect()->route('admin.ejalas.settlement_details.index');
                    break;
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}
