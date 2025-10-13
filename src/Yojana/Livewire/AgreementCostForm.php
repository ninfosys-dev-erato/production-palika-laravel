<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Src\Yojana\Controllers\AgreementCostAdminController;
use Src\Yojana\DTO\AgreementCostAdminDto;
use Src\Yojana\DTO\AgreementCostDetailsAdminDto;
use Src\Yojana\DTO\CostDetailsAdminDto;
use Src\Yojana\Models\Activity;
use Src\Yojana\Models\AgreementCost;
use Src\Yojana\Models\Plan;
use Src\Yojana\Models\Unit;
use Src\Yojana\Service\AgreementCostAdminService;
use Src\Yojana\Service\AgreementCostDetailsAdminService;

class AgreementCostForm extends Component
{
    use SessionFlash;

    public ?AgreementCost $agreementCost;
    public ?Action $action = Action::CREATE;
    public $plan;
    public $costEstimationDetails;
    public $agreementCostDetails = [];
    public $agreement;
    public $activities;
    public $units;

    public function rules(): array
    {
        return [
            'agreementCost.agreement_id' => ['required'],
            'agreementCost.total_amount' => ['nullable','min:1'],
            'agreementCost.total_vat_amount' => ['nullable'],
            'agreementCost.total_with_vat' => ['nullable','min:1'],

            'agreementCostDetails' => ['required', 'array'],
            'agreementCostDetails.*.activity_id' => ['nullable', 'string'],
            'agreementCostDetails.*.unit' => ['nullable', 'string'],
            // 'agreementCostDetails.*.quantity' => ['nullable', 'numeric', 'gt:0'],
            'agreementCostDetails.*.quantity' => ['nullable'],
            'agreementCostDetails.*.estimated_rate' => ['nullable', 'numeric'],
            // 'agreementCostDetails.*.contractor_rate' => ['required', 'numeric', 'gte:1'],
            'agreementCostDetails.*.contractor_rate' => ['nullable', 'numeric'],
            'agreementCostDetails.*.amount' => ['required', 'numeric','gt:0'],
            'agreementCostDetails.*.vat' => ['boolean'],
            'agreementCostDetails.*.vat_amount' => ['nullable', 'numeric'],
            'agreementCostDetails.*.remarks' => ['nullable'],
        ];
    }
    public function messages(): array
    {
        return [
            'agreementCost.agreement_id.required' => __('yojana::yojana.agreement_id_is_required'),
            'agreementCost.total_amount.required' => __('yojana::yojana.total_amount_is_required'),
            'agreementCost.total_amount.min:1' => __('yojana::yojana.total_amount_must_be_at_least_min_characters'),
            'agreementCost.total_vat_amount.nullable' => __('yojana::yojana.total_vat_amount_is_optional'),
            'agreementCost.total_with_vat.required' => __('yojana::yojana.total_with_vat_is_required'),
            'agreementCost.total_with_vat.min:1' => __('yojana::yojana.total_with_vat_must_be_at_least_min_characters'),
            'agreementCostDetails.required' => __('yojana::yojana.agreementcostdetails_is_required'),
            'agreementCostDetails.array' => __('yojana::yojana.agreementcostdetails_must_be_an_array'),
            'agreementCostDetails.*.activity_id.required' => __('yojana::yojana.activity_id_is_required'),
            'agreementCostDetails.*.activity_id.string' => __('yojana::yojana.activity_id_must_be_a_string'),
            'agreementCostDetails.*.unit.required' => __('yojana::yojana.unit_is_required'),
            'agreementCostDetails.*.unit.string' => __('yojana::yojana.unit_must_be_a_string'),
            'agreementCostDetails.*.quantity.required' => __('yojana::yojana.quantity_is_required'),
            'agreementCostDetails.*.quantity.numeric' => __('yojana::yojana.quantity_must_be_a_number'),
            'agreementCostDetails.*.quantity.gt:0' => __('yojana::yojana.quantity_has_invalid_validation_gt'),
            'agreementCostDetails.*.estimated_rate.nullable' => __('yojana::yojana.estimated_rate_is_optional'),
            'agreementCostDetails.*.estimated_rate.numeric' => __('yojana::yojana.estimated_rate_must_be_a_number'),
            'agreementCostDetails.*.contractor_rate.required' => __('yojana::yojana.contractor_rate_is_required'),
            'agreementCostDetails.*.contractor_rate.numeric' => __('yojana::yojana.contractor_rate_must_be_a_number'),
            'agreementCostDetails.*.contractor_rate.gte' => __('yojana::yojana.contractor_rate_should_be_greater_than_0'),
            'agreementCostDetails.*.amount.required' => __('yojana::yojana.amount_is_required'),
            'agreementCostDetails.*.amount.numeric' => __('yojana::yojana.amount_must_be_a_number'),
            'agreementCostDetails.*.amount.gt' => __('yojana::yojana.amount_must_be_greater_than_zero'),
            'agreementCostDetails.*.vat.boolean' => __('yojana::yojana.vat_must_be_true_or_false'),
            'agreementCostDetails.*.vat_amount.nullable' => __('yojana::yojana.vat_amount_is_optional'),
            'agreementCostDetails.*.vat_amount.numeric' => __('yojana::yojana.vat_amount_must_be_a_number'),
            'agreementCostDetails.*.remarks.nullable' => __('yojana::yojana.remarks_is_optional'),

        ];
    }

    public function render(){
        return view("Yojana::livewire.agreement-costs-form");
    }

    public function mount(AgreementCost $agreementCost,Action $action, Plan $plan)
    {

        $this->plan = $plan;
        $this->agreementCost = $agreementCost;
        $this->action = $action;
        $this->costEstimationDetails = $this->plan->costEstimation?->costEstimationDetail;
        $this->agreement = $this->plan->agreement;
        $this->activities = Activity::WhereNull('deleted_at')->pluck('title','id')->toArray();
        $this->units = Unit::WhereNull('deleted_at')->pluck('symbol','id')->toArray();

        if ($this->costEstimationDetails) {
            foreach ($this->costEstimationDetails as $index => $detail) {
                $this->agreementCostDetails[$index] = [
                    'cost_estimation_detail_id' => $detail->id ?? null,
                    'activity_id' => $this->activities[$detail->activity_id] ?? '-',
                    'unit' => $this->units[$detail->unit] ?? '-',
                    'quantity' => $detail->quantity ?? 0,
                    'estimated_rate' => $detail->rate ?? 0,
                    'contractor_rate' => 0,
                    'amount' => 0,
                    'vat' => false,
                    'vat_amount' => 0,
                    'remarks' => null,
                ];
            }

            if ($this->agreement?->agreementCost || $action == Action::UPDATE) {
                $this->agreementCost = $this->agreement->agreementCost->load('agreementCostDetails');
                $this->action = Action::UPDATE;

                $details = $this->agreement->agreementCost->agreementCostDetails->load('costEstimationDetail');

                foreach ($details as $index => $detail) {
                    $this->agreementCostDetails[$index] = [
                        'cost_estimation_detail_id' => $detail->cost_estimation_detail_id,
                        'activity_id' => $detail->activity_id,
                        'unit' => $detail->unit,
                        'quantity' => $detail->quantity,
                        'estimated_rate' => $detail->estimated_rate,
                        'contractor_rate' => $detail->contractor_rate,
                        'amount' => $detail->amount,
                        'vat' => isset($detail->vat_amount) && $detail->vat_amount > 0,
                        'vat_amount' => $detail->vat_amount,
                        'remarks' => $detail->remarks,
                    ];
                }
                $this->recalculateTotals();

            }
        }

    }

    public function calculateAmount($index)
    {
        $contractorRate = floatval($this->agreementCostDetails[$index]['contractor_rate'] ?? 0);
        $quantity = floatval($this->agreementCostDetails[$index]['quantity'] ?? 0);

        $this->agreementCostDetails[$index]['amount'] = $contractorRate * $quantity;

        $this->recalculateTotals();
    }

    public function calculateVAT($index)
    {
        $amount = floatval($this->agreementCostDetails[$index]['amount'] ?? 0);
        $vatChecked = $this->agreementCostDetails[$index]['vat'] ?? false;

        $this->agreementCostDetails[$index]['vat_amount'] = $vatChecked
            ? round($amount * 0.13, 2)
            : 0;

        $this->recalculateTotals();
    }

    public function recalculateTotals()
    {
        $this->agreementCost->total_amount = collect($this->agreementCostDetails)->sum('amount');
        $this->agreementCost->total_vat_amount = collect($this->agreementCostDetails)->sum('vat_amount');
        $this->agreementCost->total_with_vat = $this->agreementCost->total_amount + $this->agreementCost->total_vat_amount;
    }


    public function save()
    {
        $this->agreementCost->agreement_id = $this->agreement->id??null;
        $this->validate();
        try {
            $dto = AgreementCostAdminDto::fromLiveWireModel($this->agreementCost);
            $service = new AgreementCostAdminService();
            $costDetailsService = new AgreementCostDetailsAdminService();
            DB::beginTransaction();

            switch ($this->action) {
                case Action::CREATE:
                    $created = $service->store($dto);

                    foreach ($this->agreementCostDetails as $details) {
                        $details['agreement_cost_id'] = $created->id;
                        $costDetailsDto = AgreementCostDetailsAdminDto::fromArrayData($details);
                        $costDetailsService->store($costDetailsDto);
                    }
                    DB::commit();
                    if ($created instanceof AgreementCost) {
                        $this->successFlash(__('yojana::yojana.agreement_cost_created_successfully'));
                    } else {
                        $this->errorFlash(__('yojana::yojana.agreement_cost_failed_to_create'));
                    }
                    $this->dispatch('reload_page');
                    $this->action = Action::UPDATE;

                    break;
                    case Action::UPDATE:
                        $persistedAgreementCost = $this->agreement->agreementCost;
                        $updated = $service->update($persistedAgreementCost, $dto);

                        $persistedAgreementCost->agreementCostDetails()->delete();

                    foreach ($this->agreementCostDetails as $details) {
                        $details['agreement_cost_id'] = $updated->id;
                        $costDetailsDto = AgreementCostDetailsAdminDto::fromArrayData($details);
                        $costDetailsService->store($costDetailsDto);
                    }
                    DB::commit();
                    if ($updated instanceof AgreementCost) {
                        $this->successFlash(__('yojana::yojana.agreement_cost_updated_successfully'));
                    } else {
                        $this->errorFlash(__('yojana::yojana.agreement_cost_failed_to_update'));
                    }
                    $this->mount($this->agreementCost,Action::UPDATE,$this->plan);
                        $this->dispatch('reload_page');
                        break;
                default:
                    $this->errorFlash(__('yojana::yojana.invalid_action'));
                    break;
            }
        }catch(\Illuminate\Validation\ValidationException $e) {
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
