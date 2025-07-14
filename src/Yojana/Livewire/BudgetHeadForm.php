<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\Yojana\DTO\BudgetHeadAdminDto;
use Src\Yojana\Models\BudgetHead;
use Src\Yojana\Models\Unit;
use Src\Yojana\Service\BudgetHeadAdminService;

class BudgetHeadForm extends Component
{
    use SessionFlash;

    public ?BudgetHead $budgetHead ;
    public ?Action $action =Action::CREATE;

    public function rules(): array
    {
        return [
            'budgetHead.title' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'budgetHead.title.required' => __('yojana::yojana.the_budget_head_is_required')
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.budget-heads.form");
    }

    public function mount(BudgetHead $budgetHead, Action $action)
    {
        $this->budgetHead = $budgetHead;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = BudgetHeadAdminDto::fromLiveWireModel($this->budgetHead);
        $service = new BudgetHeadAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successToast(__('yojana::yojana.budget_head_created_successfully'));
//                return redirect()->route('admin.budget_heads.index');
                $this->resetForm();
                break;
            case Action::UPDATE:
                $service->update($this->budgetHead, $dto);
                $this->successToast(__('yojana::yojana.budget_head_updated_successfully'));
//                return redirect()->route('admin.budget_heads.index');
                $this->resetForm();
                break;
            default:
                return redirect()->route('admin.budget_heads.index');
                break;
        }
        $this->dispatch('close-modal');
    }

    #[On('edit-budget-head')]
    public function editBudgetHead(BudgetHead $budgetHead){
        $this->budgetHead = $budgetHead;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['budgetHead', 'action']);
        $this->budgetHead = new BudgetHead();
    }
    #[On('reset-form')]
    public function resetBudgetHead()
    {
        $this->resetForm();
    }
}
