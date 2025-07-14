<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\Wards\Models\Ward;
use Src\Yojana\DTO\BudgetDetailAdminDto;
use Src\Yojana\Models\BudgetDetail;
use Src\Yojana\Models\ItemType;
use Src\Yojana\Service\BudgetDetailAdminService;

class BudgetDetailForm extends Component
{
    use SessionFlash;

    public ?BudgetDetail $budgetDetail;
    public ?Action $action = Action::CREATE;
    public  $wards = [];

    public function rules(): array
    {
        return [
    'budgetDetail.ward_id' => ['required'],
    'budgetDetail.amount' => ['required'],
    'budgetDetail.program' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'budgetDetail.ward_id.required' => __('yojana::yojana.ward_id_is_required'),
            'budgetDetail.amount.required' => __('yojana::yojana.amount_is_required'),
            'budgetDetail.program.required' => __('yojana::yojana.program_is_required'),
        ];
    }

    public function render(){
        return view("Yojana::livewire.budget-details.form");
    }

    public function mount(BudgetDetail $budgetDetail,Action $action)
    {
        $this->budgetDetail = $budgetDetail;
        $this->action = $action;

        $this->wards = getWards(getLocalBodies(localBodyId: key(getSettingWithKey('palika-local-body')))->wards);
    }

    public function save()
    {
        $this->validate();
        $dto = BudgetDetailAdminDto::fromLiveWireModel($this->budgetDetail);
        $service = new BudgetDetailAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.budget_detail_created_successfully'));
//                return redirect()->route('admin.budget_details.index');
                break;
            case Action::UPDATE:
                $service->update($this->budgetDetail,$dto);
                $this->successFlash(__('yojana::yojana.budget_detail_updated_successfully'));
//                return redirect()->route('admin.budget_details.index');
                break;
            default:
                return redirect()->route('admin.budget_details.index');
                break;
        }
        $this->dispatch('close-modal');
    }

    #[On('edit-budget-details')]
    public function editBudgetDetails(BudgetDetail $budgetDetail){
        $this->budgetDetail = $budgetDetail;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }

    #[On('reset-form')]
    public function resetbudgetDetails()
    {
        $this->reset(['budgetDetail', 'action']);
        $this->budgetDetail = new BudgetDetail();
    }
}
