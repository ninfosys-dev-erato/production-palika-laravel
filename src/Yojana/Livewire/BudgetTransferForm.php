<?php

namespace Src\Yojana\Livewire;


use App\Enums\Action;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Src\Yojana\DTO\PlanAdminDto;
use Src\Yojana\DTO\BudgetTransferAdminDto;
use Src\Yojana\Models\BudgetSource;
use Src\Yojana\Models\BudgetTransfer;
use Src\Yojana\Models\BudgetTransferDetails;
use Src\Yojana\Models\Plan;
use Src\Yojana\Models\PlanArea;
use Src\Yojana\Models\PlanBudgetSource;
use Src\Yojana\Models\PlanLevel;
use Src\Yojana\Service\PlanAdminService;
use Src\Yojana\Service\BudgetTransferAdminService;

class BudgetTransferForm extends Component
{
    use sessionFlash;

    public $plans;
    public $filteredPlans;
    public $budgetSources;
    public ?BudgetTransfer $budgetTransfer;
    public ?Action $action = Action::CREATE ;
    public $planDetails;

    public $transfer = [];
    public float $total_amount = 0;
    public float $total_remaining_amount = 0;
//    public $totalRemainingAmount = 0;
    public $plan;
    public $to_plan;

    public function rules(): array
    {
        return [
            'budgetTransfer.from_plan'=>['required'],
            'budgetTransfer.to_plan'=>['required'],
            'budgetTransfer.amount'=>['required', 'numeric', 'min:1'],
            'budgetSources.*.id' => ['required'],
            'budgetSources.*.amount' => ['required','numeric'],
            'budgetSources.*.transfer_amount' => ['nullable','numeric'],
            'budgetSources.*.remaining_amount' => ['nullable','numeric','min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'budgetTransfer.from_plan.required' => 'The source plan is required.',
            'budgetTransfer.to_plan.required' => 'The destination plan is required.',
            'budgetTransfer.amount.required' => 'The transfer amount is required.',
            'budgetTransfer.amount.numeric' => 'The transfer amount must be a number.',
            'budgetTransfer.amount.min' => 'The transfer amount must be at least 1.',
            'budgetSources.*.id.required' => 'Each budget source must have an ID.',
            'budgetSources.*.amount.required' => 'The budget amount is required.',
            'budgetSources.*.amount.numeric' => 'The budget amount must be a number.',
            'budgetSources.*.transfer_amount.numeric' => 'The transfer amount must be a number.',
            'budgetSources.*.remaining_amount.required' => 'The remaining amount is required.',
            'budgetSources.*.remaining_amount.numeric' => 'The remaining amount must be a number.',
            'budgetSources.*.remaining_amount.min' => 'The transfer amount should not be greater than remaining amount',
        ];
    }


    public function mount(BudgetTransfer $budgetTransfer, Action $action)
    {
        $this->transfer = [];
        $this->budgetTransfer = $budgetTransfer;
        $this->plans = Plan::whereNull('deleted_at')->get();
        $this->filteredPlans = $this->plans;
        $this->action = $action;

    }

    public function render()
    {
        return view("Yojana::livewire.budget-transfer.form");
    }

    public function loadPlan(Plan $plan)
    {
        $this->planDetails = $plan->load('budgetSources','budgetSources.sourceType','budgetSources.budgetHead','budgetSources.expenseHead');

        if ($this->planDetails) {
            $this->budgetSources = $this->planDetails->budgetSources;
        }
        $this->budgetTransfer['to_plan'] = null;
        $this->filteredPlans = $this->plans->where('id', '!=', $plan->id);
        $this->reset(['transfer','budgetTransfer.amount']);
    }

    public function recalculateRemainingBudget(){
        foreach ($this->budgetSources as $index => $source) {
            if (isset($source->transfer_amount)){
                $source->remaining_amount = $source->getOriginal('remaining_amount') -  $source->transfer_amount ?? 0;
            }
        }

        $this->total_amount = $this->budgetSources->sum(fn($source) => $source->transfer_amount);
        $this->total_remaining_amount = $this->budgetSources->sum(fn($source) => $source->remaining_amount);

        $this->budgetTransfer->amount = $this->total_amount ?? 0;

  }

    public function save()
    {
        try {
            $validatedData = $this->validate();
            $dto = BudgetTransferAdminDto::fromLiveWireModel($this->budgetTransfer);
            $service = new BudgetTransferAdminService();

            $this->plan = Plan::find($this->budgetTransfer->from_plan);
            $this->to_plan = Plan::find($this->budgetTransfer->to_plan);

            $this->plan->remaining_budget = $this->total_remaining_amount;
            $this->to_plan->remaining_budget += $this->total_amount;

            $plan_dto = PlanAdminDto::fromLiveWireModel($this->plan);
            $to_plan_dto = PlanAdminDto::fromLiveWireModel($this->to_plan);
            $plan_service = new PlanAdminService();

            DB::beginTransaction();
        switch ($this->action) {
            case Action::CREATE:
                $transfer = $service->store($dto);
                $details = [];
                foreach ($validatedData['budgetSources'] as $index => $source) {
//                    dd($validatedData,$validatedData['budgetSources'][0]['transfer_amount'] ,$this->transfer,$index);
                    if (isset($source['transfer_amount']) && $source['transfer_amount'] > 0) {
                        $details[] = [
                            'budget_transfer_id' => $transfer->id,
                            'budget_source_id' => $source['id'],
//                            'amount' => $this->transfer[$index]['amount'] ?? 0,
                            'amount' => $source['transfer_amount'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                        unset($source['transfer_amount']);
                        $source['plan_id'] = $this->plan->id;
                        $source['updated_at'] = now();
//                        PlanBudgetSource::where('id', $source['id'])->update($source);
                    }
                    else{
                        unset($validatedData['budgetSources'][$index]);
                    }
                    unset($validatedData['budgetSources'][$index]['transfer_amount']);
                }
//                dd($details, $validatedData);
//                dd($details,$this->budgetSources, $validatedData,$validatedData['budgetSources']);
//                $this->budgetSources->each->save();
                BudgetTransferDetails::insert($details);
//                PlanBudgetSource::update($validatedData['budgetSources']);

                $plan_service->update($this->plan,$plan_dto);
                $plan_service->update($this->to_plan,$to_plan_dto);

                DB::commit();

                $this->successToast(__('yojana::yojana.budget_transferred_successfully'));
                return redirect()->route('admin.budget_transfer.index');
                break;
            case Action::UPDATE:
                $service->update($this->budgetTransfer, $dto);
                $this->successToast(__('yojana::yojana.budget_transfer_updated_successfully'));
                return redirect()->route('admin.budget_transfer.index');
                break;
            default:
                return redirect()->route('admin.budget_transfer.index');
                break;
        }
        } catch (ValidationException $e) {
            DB::rollBack();
//            dd($e->errors());
            $this->errorFlash(collect($e->errors())->flatten()->first());

        } catch (\Exception $e) {
            DB::rollBack();
//            dd($e->getMessage());
            $this->errorFlash(collect($e)->flatten()->first());

        }
    }


}
