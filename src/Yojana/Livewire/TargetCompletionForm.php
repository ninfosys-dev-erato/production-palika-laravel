<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\TargetCompletionAdminDto;
use Src\Yojana\Enums\PlanStatus;
use Src\Yojana\Models\ProcessIndicator;
use Src\Yojana\Models\Plan;
use Src\Yojana\Models\TargetCompletion;
use Src\Yojana\Service\TargetCompletionAdminService;
use Illuminate\Validation\ValidationException;

class TargetCompletionForm extends Component
{
    use SessionFlash;

    public ?TargetCompletion $targetCompletion;
    public ?Action $action = Action::CREATE;
    public ?Plan $plan;
    public $targetEntries;
    public $process_indicator;

    protected $listeners = ['load-target-completion' => 'loadTargetCompletion'];
        public function rules(): array
    {
        return [
            'targetCompletion.plan_id' => ['required'],
            'targetCompletion.target_entry_id' => ['required'],
            'targetCompletion.completed_physical_goal' => ['required'],
            'targetCompletion.completed_financial_goal' => ['required'],
//            'targetCompletion.process_indicator' => ['nullable'],
        ];
    }
    public function messages(): array
    {
        return [
            'targetCompletion.plan_id.required' => __('yojana::yojana.plan_id_is_required'),
            'targetCompletion.target_entry_id.required' => __('yojana::yojana.target_entry_id_is_required'),
            'targetCompletion.completed_physical_goal.required' => __('yojana::yojana.completed_physical_goal_is_required'),
            'targetCompletion.completed_financial_goal.required' => __('yojana::yojana.completed_financial_goal_is_required'),
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.target-completion-form");
    }

    public function mount(TargetCompletion $targetCompletion, Plan $plan)
    {
        $this->targetCompletion = $targetCompletion;
        $this->plan = $plan->load('targetEntries.processIndicator');
        $this->targetEntries = $this->plan->targetEntries;
        $targetEntry = $this->plan->targetEntries->first();
        $this->calculateRemainingGoals($targetEntry);
    }

    public function loadTargetEntry($id)
    {
        $targetEntry = $this->targetEntries->where('id', $id)->first();
        $this->calculateRemainingGoals($targetEntry);
    }

    public function loadTargetCompletion($id)
    {
        $this->action = Action::UPDATE;
        $this->targetCompletion = TargetCompletion::whereNull('deleted_at')->where('id', $id)->first();
        $targetEntry = $this->targetCompletion->targetEntry->load('processIndicator');
        $this->targetEntries = [$targetEntry];
        $this->calculateRemainingGoals($targetEntry);
        $this->dispatch('open-targetCompletionForm');
    }

    public function calculateRemainingGoals($targetEntry)
    {
        $this->targetCompletion->target_entry_id = $targetEntry?->id;
        $this->targetCompletion->physical_goals = $targetEntry?->remaining_physical_goals;
        $this->targetCompletion->financial_goals = $targetEntry?->remaining_financial_goals;
    }

    public function save()
    {
        $this->targetCompletion->plan_id = $this->plan->id;
        $this->validate();
        try {
            $dto = TargetCompletionAdminDto::fromLiveWireModel($this->targetCompletion);
            $service = new TargetCompletionAdminService();

            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
//                    if ($this->plan->status == PlanStatus::EvaluationCompleted){
//                        $this->plan->save();
//                    }
                    $this->successFlash(__('yojana::yojana.target_completion_created_successfully'));
                    $this->dispatch('open-targetCompletionTable');
                    $this->resetTargetCompletionForm();
                    break;
                case Action::UPDATE:
                    $service->update($this->targetCompletion, $dto);
                    $this->successFlash(__('yojana::yojana.target_completion_updated_successfully'));
                    $this->dispatch('open-targetCompletionTable');
                    $this->resetTargetCompletionForm();
                    break;
                default:
//                    return redirect()->route('admin.target_entries.index');
                    break;
            }
        } catch (ValidationException $e) {
            // dd($e->errors());
            $this->errorFlash(collect($e->errors())->flatten()->first());
        } catch (\Exception $e) {
            // dd($e->getMessage());
            $this->errorFlash(collect($e)->flatten()->first());
        }
    }

    public function resetTargetCompletionForm(){
        $this->targetCompletion = new TargetCompletion();
        $this->targetEntries = $this->plan->targetEntries;
        $targetEntry = $this->plan->targetEntries->first();
        $this->calculateRemainingGoals($targetEntry);
        $this->action = Action::CREATE;
    }
}
