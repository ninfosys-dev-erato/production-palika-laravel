<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\Controllers\CollateralAdminController;
use Src\Yojana\DTO\CollateralAdminDto;
use Src\Yojana\Models\Collateral;
use Src\Yojana\Models\Plan;
use Src\Yojana\Service\CollateralAdminService;

class CollateralForm extends Component
{
    use SessionFlash;

    public ?Collateral $collateral;
    public ?Action $action;
    public ?Plan $plan;

    protected $listeners = ['edit-collateral' => 'loadCollateral'];

    public function rules(): array
    {
        return [
    'collateral.plan_id' => ['required'],
    'collateral.party_type' => ['required'],
    'collateral.party_id' => ['required'],
    'collateral.deposit_type' => ['required'],
    'collateral.deposit_number' => ['required'],
    'collateral.contract_number' => ['required'],
    'collateral.bank' => ['required'],
    'collateral.issue_date' => ['required'],
    'collateral.validity_period' => ['required'],
    'collateral.amount' => ['required'],
];
    }

    public function render(){
        return view("Yojana::livewire.collaterals-form");
    }

    public function mount(Plan $plan,Collateral $collateral,Action $action)
    {
        $this->plan = $plan;
        $this->collateral = $collateral;
        $this->action = $action;
    }

    public function save()
    {
        $this->collateral->plan_id = $this->plan->id;
        $this->validate();
        $dto = CollateralAdminDto::fromLiveWireModel($this->collateral);
        $service = new CollateralAdminService();
        switch ($this->action){
            case Action::CREATE:
                $created = $service->store($dto);
                if($created instanceof Collateral){
                    $this->successFlash(__("Collateral Created Successfully"));
                }else{
                    $this->errorFlash(__("Collateral Failed to Create"));
                }
                $this->resetForm();
                break;
            case Action::UPDATE:
                $updated = $service->update($this->collateral, $dto);
                if ($updated instanceof Collateral) {
                    $this->successFlash(__("Collateral Updated Successfully"));
                } else {
                    $this->errorFlash(__("Collateral Failed to Update"));
                }
                $this->resetForm();
                break;
            default:
                $this->errorFlash(__('Invalid Action'));
                break;
        }
    }

    public function resetForm()
    {
        $this->collateral = new Collateral();
    }

    public function loadCollateral($id)
    {
        $this->action = Action::UPDATE;
        $this->collateral = Collateral::find($id);
        $this->dispatch('open-collateral-form');
    }
}
