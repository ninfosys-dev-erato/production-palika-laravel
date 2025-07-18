<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\TargetEntryAdminDto;
use Src\Yojana\Enums\PlanStatus;
use Src\Yojana\Models\ProcessIndicator;
use Src\Yojana\Models\Plan;
use Src\Yojana\Models\TargetEntry;
use Src\Yojana\Service\TargetEntryAdminService;
use Illuminate\Validation\ValidationException;

class TargetEntryForm extends Component
{
    use SessionFlash;

    public ?TargetEntry $targetEntry;
    public $TotalGoals;
    public ?Action $action = Action::CREATE;
    public ?Plan $plan;

    public $progressIndicators;

    protected $listeners = [
        'refresh-process-indicator' => 'refreshProcessIndicator',
        'load-target-entry' => 'loadTargetEntry',
        'reset-target-entry-form' => 'resetTargetEntryForm',
    ];



    public function rules(): array
    {
        return [
            'targetEntry.progress_indicator_id' => ['required'],
            'targetEntry.total_physical_progress' => ['required', 'numeric', 'min:0'],
            'targetEntry.total_financial_progress' => ['required', 'numeric', 'min:0'],

            'targetEntry.last_year_physical_progress' => ['nullable', 'numeric', 'min:0'],
            'targetEntry.last_year_financial_progress' => ['nullable', 'numeric', 'min:0'],

            'targetEntry.total_physical_goals' => ['required', 'numeric', 'min:0'],
            'targetEntry.total_financial_goals' => ['required', 'numeric', 'min:0'],

            'targetEntry.first_quarter_physical_progress' => ['required', 'numeric', 'min:0'],
            'targetEntry.second_quarter_physical_progress' => ['required', 'numeric', 'min:0'],
            'targetEntry.third_quarter_physical_progress' => ['required', 'numeric', 'min:0'],

            'targetEntry.first_quarter_financial_progress' => ['required', 'numeric', 'min:0'],
            'targetEntry.second_quarter_financial_progress' => ['required', 'numeric', 'min:0'],
            'targetEntry.third_quarter_financial_progress' => ['required', 'numeric', 'min:0'],

            'targetEntry.plan_id' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'targetEntry.progress_indicator_id.required' => __('yojana::yojana.progress_indicator_id_is_required'),
            'targetEntry.total_physical_progress.required' => __('yojana::yojana.total_physical_progress_is_required'),
            'targetEntry.total_financial_progress.required' => __('yojana::yojana.total_financial_progress_is_required'),
            'targetEntry.last_year_physical_progress.required' => __('yojana::yojana.last_year_physical_progress_is_required'),
            'targetEntry.last_year_financial_progress.required' => __('yojana::yojana.last_year_financial_progress_is_required'),
            'targetEntry.total_physical_goals.required' => __('yojana::yojana.total_physical_goals_is_required'),
            'targetEntry.total_financial_goals.required' => __('yojana::yojana.total_financial_goals_is_required'),
            'targetEntry.first_quarter_physical_progress.required' => __('yojana::yojana.first_quarter_physical_progress_is_required'),
            'targetEntry.first_quarter_financial_progress.required' => __('yojana::yojana.first_quarter_financial_progress_is_required'),
            'targetEntry.second_quarter_physical_progress.required' => __('yojana::yojana.second_quarter_physical_progress_is_required'),
            'targetEntry.second_quarter_financial_progress.required' => __('yojana::yojana.second_quarter_financial_progress_is_required'),
            'targetEntry.third_quarter_physical_progress.required' => __('yojana::yojana.third_quarter_physical_progress_is_required'),
            'targetEntry.third_quarter_financial_progress.required' => __('yojana::yojana.third_quarter_financial_progress_is_required'),
            'targetEntry.plan_id.required' => __('yojana::yojana.plan_id_is_required'),
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.target-entry.form");
    }

    public function mount(TargetEntry $targetEntry, Plan $plan)
    {
        $this->targetEntry = $targetEntry;
        $this->plan = $plan;
        $this->progressIndicators = ProcessIndicator::Wherenull('deleted_at')->pluck("title", "id")->toArray();
    }


    public function calculateTotalPhysicalGoals()
    {
        $totalPlanning = (float)($this->targetEntry->total_physical_progress ?? 0);
        $lastYearProgress = (float)($this->targetEntry->last_year_physical_progress ?? 0);

        $totalGoals = $totalPlanning - $lastYearProgress;
        $this->targetEntry->total_physical_goals = $totalGoals;
    }

    public function calculateFinancialGoals()
    {
        $totalPlanning = (float)($this->targetEntry->total_financial_progress ?? 0);
        $lastYearProgress = (float)($this->targetEntry->last_year_financial_progress ?? 0);

        $totalGoals = $totalPlanning - $lastYearProgress;
        $this->targetEntry->total_financial_goals = $totalGoals;

    }

    public function calculatePhysicalQuarter2()
    {
        $Q1 = (float)($this->targetEntry->first_quarter_physical_progress ?? 0);
        $total = (float)($this->targetEntry->total_physical_goals ?? 0);

        $Q2= $total - $Q1;

        $this->targetEntry->second_quarter_physical_progress = $Q2 > 0 ? $Q2 : 0;

    }

    public function calculateFinancialQuarter2()
    {
        $Q1 = (float)($this->targetEntry->first_quarter_financial_progress ?? 0);
        $total = (float)($this->targetEntry->total_financial_goals ?? 0);

        $Q2 = $total - $Q1;

        $this->targetEntry->second_quarter_financial_progress = $Q2 > 0 ? $Q2 : 0;
    }


    public function calculatePhysicalQuarter3()
    {
        $Q1 = (float)($this->targetEntry->first_quarter_physical_progress ?? 0);
        $Q2 = (float)($this->targetEntry->second_quarter_physical_progress ?? 0);
        $total = (float)($this->targetEntry->total_physical_goals ?? 0);

        $Q3 = $total - $Q1 - $Q2;

        $this->targetEntry->third_quarter_physical_progress = $Q3 > 0 ? $Q3 : 0;
    }

    public function calculateFinancialQuarter3()
    {
        $Q1 = (float)($this->targetEntry->first_quarter_financial_progress ?? 0);
        $Q2 = (float)($this->targetEntry->second_quarter_financial_progress ?? 0);
        $total = (float)($this->targetEntry->total_financial_goals ?? 0);

        $Q3 = $total - $Q1 - $Q2;

        $this->targetEntry->third_quarter_financial_progress = $Q3 > 0 ? $Q3 : 0;
    }

    public function verifyCalculation()
    {
        if (
            $this->targetEntry->total_physical_progress != $this->targetEntry->last_year_physical_progress + $this->targetEntry->total_physical_goals
            || $this->targetEntry->total_physical_goals != $this->targetEntry->first_quarter_physical_progress + $this->targetEntry->second_quarter_physical_progress + $this->targetEntry->third_quarter_physical_progress
        ){
            $this->errorFlash('The Physical Progress Calculation is not valid');
        }

        if (
            $this->targetEntry->total_financial_progress != $this->targetEntry->last_year_financial_progress + $this->targetEntry->total_financial_goals
            || $this->targetEntry->total_financial_goals != $this->targetEntry->first_quarter_financial_progress + $this->targetEntry->second_quarter_financial_progress + $this->targetEntry->third_quarter_financial_progress
        ){
            $this->errorFlash('The Financial Progress Calculation is not valid');
        }


    }

    public function refreshProcessIndicator()
    {
        $this->progressIndicators = ProcessIndicator::Wherenull('deleted_at')->pluck("title", "id")->toArray();
    }

    public function loadTargetEntry($id)
    {
        $this->targetEntry = TargetEntry::whereNull('deleted_at')->find($id);
        $this->action = Action::UPDATE;
        $this->dispatch('open-targetEntryForm');
    }

    public function save()
    {
        $this->verifyCalculation();
        $this->targetEntry->plan_id = $this->plan->id;
        $this->validate();
        try {
            $dto = TargetEntryAdminDto::fromLiveWireModel($this->targetEntry);
            $service = new TargetEntryAdminService();

            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    if ($this->plan->status == PlanStatus::CostEstimationEntry){
                        $this->plan->status = PlanStatus::TargetEntry;
                        $this->plan->save();
                    }
                    $this->successFlash(__('yojana::yojana.target_entry_created_successfully'));
                    $this->dispatch('reload_page');
                    break;
                case Action::UPDATE:
                    $service->update($this->targetEntry, $dto);
                    $this->successFlash(__('yojana::yojana.target_entry_updated_successfully'));
                   $this->dispatch('reload_page');
                   break;
                default:
//                    return redirect()->route('admin.target_entries.index');
                    break;
            }
        } catch (ValidationException $e) {
//            dd($e->errors());
            $this->errorFlash(collect($e->errors())->flatten()->first());
        } catch (\Exception $e) {
//            dd($e->getMessage());
            $this->errorFlash(collect($e)->flatten()->first());
        }
    }

    public function resetTargetEntryForm(){
        $this->targetEntry = new TargetEntry();
        $this->action = Action::CREATE;
    }
}
