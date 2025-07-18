<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\Yojana\DTO\ExpenseHeadAdminDto;
use Src\Yojana\Models\ExpenseHead;
use Src\Yojana\Models\Unit;
use Src\Yojana\Service\ExpenseHeadAdminService;

class ExpenseHeadForm extends Component
{
    use SessionFlash;

    public ?ExpenseHead $expenseHead;
    public ?Action $action = Action::CREATE;

    public function rules(): array
    {
        return [
            'expenseHead.title' => ['required'],
            'expenseHead.code' => ['required'],
            'expenseHead.type' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'expenseHead.title.required' => __('yojana::yojana.the_expense_head_is_required')
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.expense-heads.form");
    }

    public function mount(ExpenseHead $expenseHead, Action $action)
    {
        $this->expenseHead = $expenseHead;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = ExpenseHeadAdminDto::fromLiveWireModel($this->expenseHead);
        $service = new ExpenseHeadAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successToast(__('yojana::yojana.expense_head_created_successfully'));
//                return redirect()->route('admin.expense_heads.index');
                $this->resetForm();
                break;
            case Action::UPDATE:
                $service->update($this->expenseHead, $dto);
                $this->successToast(__('yojana::yojana.expense_head_updated_successfully'));
//                return redirect()->route('admin.expense_heads.index');
            $this->resetForm();
                break;
            default:
                return redirect()->route('admin.expense_heads.index');
                break;
        }
        $this->dispatch('close-modal');
    }

    #[On('edit-expense-head')]
    public function editExpenseHead (ExpenseHead $expenseHead){
        $this->expenseHead = $expenseHead;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }

    private function resetForm()
    {
        $this->reset(['expenseHead', 'action']);
        $this->expenseHead = new ExpenseHead();
    }
    #[On('reset-form')]
    public function resetUnit()
    {
        $this->resetForm();
    }


}
