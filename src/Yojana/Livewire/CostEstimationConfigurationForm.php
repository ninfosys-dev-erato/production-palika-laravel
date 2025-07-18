<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Src\Yojana\DTO\CostEstimationAdminDto;
use Src\Yojana\Enums\AmountBasis;
use Src\Yojana\Enums\LetterTypes;
use Src\Yojana\Models\Activity;
use Src\Yojana\Models\Configuration;
use Src\Yojana\Models\CostEstimation;
use Src\Yojana\Models\CostEstimationDetail;
use Src\Yojana\Models\Plan;
use Src\Yojana\Models\ProjectActivityGroup;
use Src\Yojana\Service\CostEstimationAdminService;

class CostEstimationConfigurationForm extends Component
{
    use SessionFlash;

    public ?Plan $plan;
    public ?CostEstimation $costEstimation;
    public ?Action $action;
    public $activities;
    public array $records = [];
    public array $configRecords = [];

    public $configurations;
    public $configuration;
    public $amountBasis;
    public $base_value = 0;
    public $operation_type = 'add';
    public $rate = null;

    public $total_amount = 0;
    public $amount = 0;
    public $totalWithVat = 0;
    public $totalWithConfig = 0;

    public bool $customConfiguration = false;

    protected $listeners = ['updateTotals'];
    public $based_on;


    public function rules(): array
    {
        return [
            'configuration' => 'required',
            'operation_type' => 'required',
            'rate' => ['required', 'numeric', 'min:0'],
            'amount' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'rate.required' => __('yojana::yojana.rate_is_required'),
            'rate.numeric' => __('yojana::yojana.rate_must_be_a_number'),
            'rate.min:1' => __('yojana::yojana.rate_must_be_at_least_min_characters'),
        ];
    }

    public function render(): View
    {
        return view("Yojana::livewire.cost-estimation-configuration.form");
    }

    public function mount(Plan $plan): void
    {
        $this->plan = $plan;
        //        dd($this->plan->allocated_budget);
        $this->configurations = Configuration::whereNull('deleted_at')->get();
        $this->amountBasis = AmountBasis::getForWeb();
    }

    public function updateRate($id): void
    {
        $config = $this->configurations->firstWhere('id', $id);
        if ($config) {
            $this->rate = $config->rate;
            $this->calculateConfigAmount();
        }
    }

    public function updateTotals($data)
    {
        $this->total_amount = $data['total_amount'];
        $this->totalWithVat = $data['totalWithVat'];
        $this->totalWithConfig = $data['totalWithConfig'];
    }

    public function calculateConfigAmount(): void
    {
        $this->amount = $this->rate * $this->base_value / 100;
    }

    public function addConfigRecords(): void
    {
        $this->validate();
        $data = [
            "configuration" =>  $this->configuration,
            "operation_type" =>  $this->operation_type,
            "rate" => $this->rate,
            "amount" => $this->amount,
        ];
        $this->dispatch('configRecordAdded', $data);
    }



    public function updateBaseValue($index): void
    {
        //        dd($this->totalWithVat, $this->total_amount);

        // $cases = AmountBasis::cases();

        switch ($this->based_on) {
            case AmountBasis::AllocatedBudget->value:
                $this->base_value = $this->plan->allocated_budget;
                $this->customConfiguration = false;
                break;
            case AmountBasis::EstimatedSubTotalExcludingVat->value:
                $this->base_value = $this->total_amount;
                $this->customConfiguration = false;
                break;
            case AmountBasis::EstimatedSubTotalIncludingVat->value:
                $this->base_value = $this->totalWithVat;
                $this->customConfiguration = false;
                break;
            case AmountBasis::RunningTotal->value:
                $this->base_value = $this->totalWithConfig;
                $this->customConfiguration = false;
                break;
            case 'other':
                $this->customConfiguration = true;
                break;
            default:
                $this->customConfiguration = false;
        }
        $this->calculateConfigAmount();
    }


    public function saveConfiguration()
    {
        try {
            DB::beginTransaction();

            $this->validate();
            $dto = CostEstimationAdminDto::fromLiveWireModel($this->costEstimation);
            $service = new CostEstimationAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $costEstimation = $service->store($dto);
                    $this->successFlash(__('yojana::yojana.cost_estimation_created_successfully'));
                    break;
                case Action::UPDATE:
                    $service->update($this->costEstimation, $dto);
                    $this->successFlash(__('yojana::yojana.cost_estimation_updated_successfully'));
                    break;
            }
            DB::commit();
            //            return redirect()->route('admin.plans.show',['id'=>$this->costEstimation->id]);


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
