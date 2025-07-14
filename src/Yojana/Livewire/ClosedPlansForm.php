<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\ActivityAdminDto;
use Src\Yojana\Models\Activity;
use Src\Yojana\Models\PlanArea;
use Src\Yojana\Models\ProjectActivityGroup;
use Src\Yojana\Models\Unit;
use Src\Yojana\Service\ActivityAdminService;
use Livewire\Attributes\On;
use Src\Yojana\Enums\PlanTypes;
use Src\Yojana\Models\BudgetHead;
use Src\Yojana\Models\ExpenseHead;
use Src\Yojana\Models\ImplementationLevel;
use Src\Yojana\Models\ProjectGroup;

class ClosedPlansForm extends Component
{
    use SessionFlash;

    public ?Activity $activity;
    public ?Action $action = Action::CREATE;
    public $areas;
    public $area;
    public $units;
    public $budgetHeads;
    public $budgetHead; //stores the selected value from select dropdown
    public $expenseHeads;
    public $expenseHead; //stores the selected value from select dropdown
    public $planTypes;
    public $planType; //stores the selected value from select dropdown
    public $projectGroups;
    public $projectGroup; //stores the selected value from select dropdown
    public $implementationLevels;
    public $implementationLevel; //stores the selected value from select dropdown

    public function rules(): array
    {
        return [
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.reports.closed-plans");
    }

    public function mount()
    {
        $this->areas = PlanArea::whereNull('deleted_at')->get();
        $this->budgetHeads = BudgetHead::whereNull('deleted_at')->get();
        $this->expenseHeads = ExpenseHead::whereNull('deleted_at')->get();
        $this->projectGroups = ProjectGroup::whereNull('deleted_at')->get();
        $this->planTypes = PlanTypes::cases();
        $this->implementationLevels = ImplementationLevel::whereNull('deleted_at')->get();
    }

    public function search()
    {
        // $area_id = $this->area;
        // $budgetHead_id = $this->budgetHead;
        // $expenseHead_id = $this->expenseHead;
        // $planType = $this->planType;
        // $projectGroup_id = $this->projectGroup;
        // $implementationLevel_id = $this->implementationLevel;
        $this->dispatch(
            'search',
            $this->area,
            $this->budgetHead,
            $this->expenseHead,
            $this->planType,
            $this->projectGroup,
            $this->implementationLevel
        );
    }
    public function clearField()
    {
        $this->reset(
            'area',
            'budgetHead',
            'expenseHead',
            'planType',
            'projectGroup',
            'implementationLevel'
        );
        $this->search();
    }



    public function save()
    {
        $this->validate();
        $dto = ActivityAdminDto::fromLiveWireModel($this->activity);
        $service = new ActivityAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.activity_created_successfully'));
                return redirect()->route('admin.activities.index');
                break;
            case Action::UPDATE:
                $service->update($this->activity, $dto);
                $this->successFlash(__('yojana::yojana.activity_updated_successfully'));
                return redirect()->route('admin.activities.index');
                break;
            default:
                return redirect()->route('admin.activities.index');
                break;
        }
    }
    #[On('edit-activity')]
    public function activity(Activity $activity)
    {
        $this->activity = $activity;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    #[On('reset-form')]
    public function resetConfiguration()
    {
        $this->reset(['activity', 'action']);
        $this->activity = new Activity();
    }
}
