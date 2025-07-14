<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\BudgetSourceAdminDto;
use Src\Yojana\Models\BudgetSource;
use Src\Yojana\Models\ImplementationLevel;
use Src\Yojana\Models\PlanLevel;
use Src\Yojana\Service\BudgetSourceAdminService;
use Livewire\Attributes\On;

class BudgetSourceForm extends Component
{
    use SessionFlash;

    public ?BudgetSource $budgetSource;
    public ?Action $action = Action::CREATE;
    public $levels;

    public function rules(): array
    {
        return [
            'budgetSource.title' => ['required'],
            'budgetSource.code' => ['required'],
            'budgetSource.level_id' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'budgetSource.title.required' => __('yojana::yojana.title_is_required'),
            'budgetSource.code.required' => __('yojana::yojana.code_is_required'),
            'budgetSource.level_id.required' => __('yojana::yojana.level_id_is_required'),
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.budget-sources.form");
    }

    public function mount(BudgetSource $budgetSource, Action $action)
    {
        $this->budgetSource = $budgetSource;
        $this->action = $action;
        $this->levels = ImplementationLevel::pluck('title', 'id');
    }

    public function save()
    {
        $this->validate();
        $dto = BudgetSourceAdminDto::fromLiveWireModel($this->budgetSource);
        $service = new BudgetSourceAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.budget_source_created_successfully'));
                $this->dispatch('close-modal');
//                return redirect()->route('admin.budget_sources.index');
                break;
            case Action::UPDATE:
                $service->update($this->budgetSource, $dto);
                $this->successFlash(__('yojana::yojana.budget_source_updated_successfully'));
                $this->dispatch('close-modal');
//                return redirect()->route('admin.budget_sources.index');
                break;
            default:
//                return redirect()->route('admin.budget_sources.index');
                break;
        }
    }


    #[On('edit-budgetSource')]
    public function editBudgetSource(BudgetSource $budgetSource)
    {
        $this->budgetSource = $budgetSource;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    #[On('reset-form')]
    public function resetBudgetSource()
    {
        $this->reset(['budgetSource', 'action']);
        $this->budgetSource = new BudgetSource();
    }
}
