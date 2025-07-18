<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\Yojana\DTO\AdvancePaymentAdminDto;
use Src\Yojana\DTO\BudgetSourceLogDto;
use Src\Yojana\DTO\PaymentAdminDto;
use Src\Yojana\DTO\PaymentTaxDeductionAdmindto;
use Src\Yojana\Enums\ImplementationMethods;
use Src\Yojana\Enums\Installments;
use Src\Yojana\Enums\PlanStatus;
use Src\Yojana\Models\AdvancePayment;
use Src\Yojana\Models\Configuration;
use Src\Yojana\Models\Evaluation;
use Src\Yojana\Models\Payment;
use Src\Yojana\Models\Plan;
use Src\Yojana\Models\PlanBudgetSource;
use Src\Yojana\Service\AdvancePaymentAdminService;
use Src\Yojana\Service\BudgetSourceLogAdminService;
use Src\Yojana\Service\PaymentAdminService;
use Src\Yojana\Service\PaymentTaxDeductionAdminService;

class PaymentForm extends Component
{
    use SessionFlash;

    public ?AdvancePayment $advancePayment;
    public ?Action $action = Action::CREATE;
    public ?Plan $plan;
    public $installments;
    public $totalPaid = 0;
    public $agreement;
    public $evaluation = null;
    public $budgetSources;
    public $budgetSourceDetails = [];
    public $advancePayments;
    public $taxHeads;
    public $category;

    public $payment = [];
    public $tax = [];
    public $taxRecords = [];

    protected $listeners = ['load-evaluation-payment' => 'loadEvaluationPayment', 'edit-payment' => 'loadPayment'];
    public  $calculatedRemaining = [];
    public array $budgetSourceLog;


    public function rules(): array
    {
        $rules = [
            'payment.plan_id' => ['required'],
            'payment.payment_date' => ['required'],
            'payment.estimated_cost' => ['required'],
            'payment.agreement_cost' => ['required'],
            'payment.total_paid_amount' => ['required'],
            'payment.previous_advance' => ['nullable'],
            'payment.current_advance' => ['nullable'],
            'payment.previous_deposit' => ['nullable'],
            'payment.current_deposit' => ['nullable'],
            'payment.total_tax_deduction' => ['required'],
            'payment.total_deduction' => ['required'],
            'payment.paid_amount' => ['required', 'min:0'],
            'budgetSourceDetails.*.amount' => ['required', 'min:0'],
        ];

        if ($this->category === 'plan') {
            $rules = array_merge($rules, $this->planRules());
        }

        if ($this->category === 'program') {
            $rules = array_merge($rules, $this->programRules());
        }

        return $rules;
    }

    public function programRules()
    {
        return [
            'payment.bill_amount' => ['required'],
        ];
    }

    public function planRules()
    {
        return [
            'payment.evaluation_id' => ['required'],
            'payment.installment' => ['required'],
            'payment.evaluation_amount' => ['required'],

        ];
    }

    public function mount(Plan $plan, Action $action, $category)
    {
        $this->plan = $plan;
        $this->budgetSources = [];

        $this->category = $category;

        $this->loadPayment();
    }

    public function render()
    {
        return view("Yojana::livewire.payment.form");
    }

    public function calculateAdvanceDue()
    {
        $totalPaid = (int) ($this->payment['total_paid_amount'] ?? 0);
        $advanceCurrent = (int) ($this->payment['current_advance'] ?? 0);

        $this->payment['advance_due'] = $totalPaid - $advanceCurrent;
        $this->payment['advance_deduction'] = $advanceCurrent;
        $this->calculateTotals();
    }

    public function calculateDeposit()
    {
        $currentDeposit = (int) ($this->payment['current_deposit'] ?? 0);
        $this->payment['deposit_deduction'] = $currentDeposit;
        $this->payment['total_deposit'] = $currentDeposit;
        $this->calculateTotals();
    }

    public function updateRate($id)
    {
        $taxHead = $this->taxHeads->firstWhere('id', $id);
        $this->tax['rate'] = (int) ($taxHead->rate ?? 0);

        if (!empty($this->tax['evaluation_amount'])) {
            $this->calculateTax();
        }
    }

    public function calculateTax()
    {
        $rate = (int) ($this->tax['rate'] ?? 0);
        $evaluationAmount = (int) ($this->tax['evaluation_amount'] ?? 0);
        $this->tax['amount'] = $rate / 100 * $evaluationAmount;
    }

    public function editPayment()
    {

    }

    public function addTax()
    {
        $this->validate([
            'tax.name' => 'required',
            'tax.evaluation_amount' => 'required|numeric|min:0',
            'tax.rate' => 'required|numeric|min:0',
            'tax.amount' => 'required|numeric|min:0',
        ]);

        $taxModel = $this->taxHeads->firstWhere('id', $this->tax['name']);
        $this->tax['title'] = $taxModel->title ?? 'Unknown';
        $this->taxRecords[] = $this->tax;
        $this->resetTax();
        $this->calculateTotals();
    }

    public function resetTax()
    {
        $this->tax = [
            'name' => '',
            'evaluation_amount' => 0,
            'rate' => 0,
            'amount' => 0,
        ];
    }

    public function calculateTotalAmount(){
        $this->calculateTotals();
    }

    public function removeTaxRecord($index)
    {
        unset($this->taxRecords[$index]);
        $this->taxRecords = array_values($this->taxRecords);
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $totalTax = collect($this->taxRecords)->sum(function ($tax) {
            return (int) ($tax['amount'] ?? 0);
        });

        $advanceDeduction = (int) ($this->payment['advance_deduction'] ?? 0);
        $depositDeduction = (int) ($this->payment['deposit_deduction'] ?? 0);

        if ($this->category === 'plan') {
            $evaluationAmount = (int)($this->payment['evaluation_amount'] ?? 0);
        }
        elseif ($this->category === 'program') {
            $evaluationAmount = (int)($this->payment['bill_amount'] ?? 0);
        }

        $this->payment['total_tax_deduction'] = $totalTax;
        $this->payment['total_deduction'] = $totalTax + $advanceDeduction + $depositDeduction;
        $this->payment['paid_amount'] = $evaluationAmount - $this->payment['total_deduction'];
    }

    public function calculateRemainingBudget($index)
    {
        $amount = $this->budgetSourceDetails[$index]['amount'] ?? 0;
        $originalRemaining = $this->budgetSources[$index]['remaining_amount'] ?? 0;

        $this->calculatedRemaining[$index] = (float)$originalRemaining - (float)$amount;
        $this->budgetSources[$index]['remaining_amount'] = $this->calculatedRemaining[$index];
    }



    public function save()
    {

        $this->payment['plan_id'] = $this->plan->id;

        if ($this->category == 'plan'){
            $this->payment['evaluation_id'] = $this->evaluation->id;
        }

        try {
            $validated = $this->validate();
            DB::beginTransaction();

            $dto = PaymentAdminDto::fromArrayData($this->payment);
            $service = new PaymentAdminService();
            $budgetSourceLogService = new BudgetSourceLogAdminService();
            $taxService = new PaymentTaxDeductionAdminService();

            switch ($this->action) {
                case Action::CREATE:
                    $saved = $service->store($dto);
//                    foreach ($this->budgetSources as $index => $budgetSource) {
//                        if ($this->calculatedRemaining[$index] >= 0 ) {
//                            $budgetSource['remaining_amount'] = $this->calculatedRemaining[$index] ?? $budgetSource['remaining_amount'];
//                            $budgetSourceLogDto = BudgetSourceLogDto::fromLiveWireModel($budgetSource);
//                            $budgetSourceLogService->store($budgetSourceLogDto);
//                        }
//                else{
//                    return $this->errorFlash('Remaining Budget Source Amount exceeded');
//                }
//                    }
                    if ($this->category == 'plan' && count($this->calculatedRemaining) > 0) {
                        foreach ($this->budgetSources as $index => $budgetSource) {
                            $amount = $this->budgetSourceDetails[$index]['amount'];
                            if ($amount > 0) {
                                $budgetSourceLog = [
                                    'payment_id' => $saved->id,
                                    'plan_budget_source_id' => $budgetSource['id'],
                                    'amount' => $amount
                                ];
                                $budgetSourceLogDto = BudgetSourceLogDto::fromArrayData($budgetSourceLog);
                                $budgetSourceLogService->store($budgetSourceLogDto);
                            }
                        }
                    }

                    foreach ($this->taxRecords as $taxRecord) {
                        $taxRecord['payment_id'] = $saved->id;
                        $taxDto = PaymentTaxDeductionAdmindto::fromArrayData($taxRecord);
                        $taxService->store($taxDto);
                    }
                    $this->plan->status = PlanStatus::Completed;
                    $this->plan->save();

                    DB::commit();
                    $this->action = Action::UPDATE;
                    $this->successFlash(__('yojana::yojana.payment_created_successfully'));
                    $this->dispatch('reload_page');
                    break;
                case Action::UPDATE:
                    $payment = $this->plan->payments->firstWhere('id', $this->payment['id']);
                    $updated = $service->update($payment, $dto);

                    if ($this->category == 'plan' && count($this->calculatedRemaining) > 0) {

                        $paymentLogs = $payment->budgetSourcePaymentLogs;

                        // Create a map of plan_budget_source_id => amount from paymentLogs
                        $paymentLogMap = $paymentLogs->pluck('amount', 'plan_budget_source_id');

                        foreach ($this->budgetSources as $index => $budgetSource) {
                            if ($this->calculatedRemaining[$index] >= 0 && isset($paymentLogMap[$budgetSource->id])) {
                                $budgetSourceLog = [
                                    'payment_id' => $updated->id,
                                    'plan_budget_source_id' => $budgetSource['id'],
                                    'amount' => $this->budgetSourceDetails[$index]['amount']
                                ];
                                $log = $paymentLogs->firstWhere('plan_budget_source_id', $budgetSource['id'] ?? null);
                                $budgetSourceLogDto = BudgetSourceLogDto::fromArrayData($budgetSourceLog);
                                $budgetSourceLogService->update($log,$budgetSourceLogDto);
                            } else {
                                return $this->errorFlash('Remaining Budget Source Amount exceeded');
                            }
                        }
                    }

                    $payment->taxDeductions()->delete();
                    foreach ($this->taxRecords as $taxRecord) {
                        $taxRecord['payment_id'] = $updated->id;
                        $taxDto = PaymentTaxDeductionAdmindto::fromArrayData($taxRecord);
                        $taxService->store($taxDto);
                    }
                    DB::commit();
                    $this->dispatch('reload_page');

                    $this->successFlash(__('yojana::yojana.payment_updated_successfully'));

                    break;
                default:
                    break;
            }
        } catch (ValidationException $e) {
            DB::rollBack();

//                        dd($e->errors());
            $this->errorFlash(collect($e->errors())->flatten()->first());
        } catch (\Exception $e) {
            DB::rollBack();

//                        dd($e->getMessage());
            $this->errorFlash(collect($e)->flatten()->first());
        }
    }

    public function loadEvaluationPayment($id)
    {
        $paymentId = null;
        if ($this->category == 'plan' && isset($id) ) {
            $this->evaluation = $this->plan->evaluations->firstWhere('id', $id);
            $this->payment['evaluation_date'] = $this->evaluation->evaluation_date;
        }
        $this->evaluation->load('payment');
        if ($this->plan->payments->isNotEmpty()){
            $paymentId = $this->evaluation->payment->id;
        }
        $this->loadPayment($paymentId);
    }

    public function loadPayment($id = null)
    {
        $this->plan = $this->plan->load([
            'budgetSources.sourceType',
            'budgetSources.budgetDetail',
            'budgetSources.budgetHead',
            'budgetSources.expenseHead',
            'budgetSources.fiscalYear',
            'evaluations',
            'costEstimation',
            'agreement.agreementCost',
            'advancePayments',
            'payments.budgetSourcePaymentLogs',
            'implementationAgency.application',
            'implementationAgency.organization',
            'implementationAgency.consumerCommittee'
        ]);

        $model = $this->plan?->implementationMethod?->model;

        $agreement = $this->plan?->agreement;


        if (!$this->evaluation && $this->category == 'plan' && $this->plan->payments->isNotEmpty()){
            $payment = $this->plan->payments->firstWhere('id', $id);
            $this->evaluation = $payment?->evaluation;
        }

        // Ensure this is always a collection
        $this->budgetSources = $this->plan->budgetSources ?? collect();

//        if ($this->category == 'plan') {
//            if ($this->evaluation == null) {
////                return false;
//            }
//            $this->totalPaid = $this->plan->payments
//                ->where('evaluation_id', $this->evaluation?->id)
//                ->sum('paid_amount');
//
//            $evaluationAmount = $this->evaluation->evaluation_amount;
//
//            // Prevent rendering if fully paid
//            if ($this->totalPaid >= $evaluationAmount) {
//                abort(403, 'This evaluation is already fully paid.');
//            }
//        }

        $this->payment = [
            'agreement_date' => optional($agreement)->created_at?->format('Y-m-d') ?? '',
            'agreed_completion_date' => optional($agreement)->plan_completion_date ?? '',
            'evaluation_date' => $this->evaluation?->evaluation_date ?? '',
            'implementation_method' => $model->label() ?? '',

            'estimated_cost' => (int) optional($this->plan->costEstimation)->total_cost ?? 0,
            'agreement_cost' => $agreementCost = (int) optional($agreement?->agreementCost)->total_with_vat ?? 0,
            'total_paid_amount' => $totalPaidAmount = (int) $this->plan->advancePayments->sum('paid_amount') ?? 0,
            'total_payable_amount' => $agreementCost - $totalPaidAmount,

            'installment' => $this->evaluation?->installment_no ?? null,
            'evaluation_amount' => (int) $this->evaluation?->evaluation_amount ?? 0,
//            'evaluation_amount_without_tax' => $this->payment['evaluation_amount'] - (int) $this->evaluation?->total_vat ?? 0,

            // Advance related
            'previous_advance' => 0,
            'current_advance' => 0,
            'advance_due' => 0,
            'advance_deduction' => 0,

            // Deposit related
            'total_deposit' => 0,
            'previous_deposit' => 0,
            'deposit_deduction' => 0,
            'current_deposit' => 0,

            // Totals
            'total_tax_deduction' => 0,
            'total_deduction' => 0,
            'paid_amount' => 0,

            'bill_amount' => 0,
        ];
        $this->payment['evaluation_amount_without_tax'] = $this->payment['evaluation_amount'] - ((int) $this->evaluation?->total_vat ?? 0);

        // Load available tax heads
        $this->taxHeads = Configuration::whereNull('deleted_at')->get();

        if ($this->category == 'plan' && ($this->plan?->payments?->contains('id', $id) || $this->action == Action::UPDATE)) {
            $payment = $this->plan?->payments?->firstWhere('id',$id);
            $this->action = Action::UPDATE;
//            $payment = $this->evaluation->payment;
            $this->payment["payment_date"] = $payment->payment_date;
            $this->payment["estimated_cost"] = $payment->estimated_cost;
            $this->payment["agreement_cost"] = $payment->agreement_cost;
            $this->payment["total_paid_amount"] = $payment->total_paid_amount;
            $this->payment["installment"] = $payment->installment->label();
            $this->payment["evaluation_amount"] = $payment->evaluation_amount;
            $this->payment["previous_advance"] = $payment->previous_advance;
            $this->payment["current_advance"] = $payment->current_advance;
            $this->payment["previous_deposit"] = $payment->previous_deposit;
            $this->payment["current_deposit"] = $payment->current_deposit;
            $this->payment["total_tax_deduction"] = $payment->total_tax_deduction;
            $this->payment["total_deduction"] = $payment->total_deduction;
            $this->payment["paid_amount"] = $payment->paid_amount;
            $this->payment["id"] = $payment->id;

            $paymentLogs = $payment->budgetSourcePaymentLogs;

            // Create a map of plan_budget_source_id => amount from paymentLogs
            $paymentLogMap = $paymentLogs->pluck('amount', 'plan_budget_source_id');

            foreach ($this->budgetSources as $index => $budgetSource) {
                if (isset($paymentLogMap[$budgetSource->id])) {
                    $this->budgetSourceDetails[$index] = ['amount' => $paymentLogMap[$budgetSource->id] ?? 0];
                    $budgetSource->remaining_amount = $budgetSource->remaining_amount + $paymentLogMap[$budgetSource->id] ?? 0;

                }
            }


            $this->taxRecords = $this->evaluation?->payment?->taxDeductions?->toArray() ?? [];
            foreach ($this->taxRecords as $index => $taxRecord) {
                $matchingHead = $this->taxHeads->firstWhere('id', $taxRecord['name']);
                if ($matchingHead) {
                    $this->taxRecords[$index]['title'] = $matchingHead->title;
                }
            }
        }

        if ($this->category == 'program' && ($this->plan?->payments?->contains('id', $id) || $this->action == Action::UPDATE)) {
            $payment = $this->plan?->payments?->firstWhere('id',$id);
            $this->action = Action::UPDATE;
            $this->payment["payment_date"] = $payment->payment_date ?? '';
            $this->payment["estimated_cost"] = $payment->estimated_cost ?? 0;
            $this->payment["agreement_cost"] = $payment->agreement_cost ?? 0;
            $this->payment["total_paid_amount"] = $payment->total_paid_amount ?? 0;
            $this->payment["previous_advance"] = $payment->previous_advance;
            $this->payment["current_advance"] = $payment->current_advance;
            $this->payment["total_tax_deduction"] = $payment->total_tax_deduction;
            $this->payment["total_deduction"] = $payment->total_deduction;
            $this->payment["paid_amount"] = $payment->paid_amount;
            $this->payment["bill_amount"] = $payment->bill_amount;
            $this->payment["id"] = $payment->id;

            $payment->load('taxDeductions');
            $this->taxRecords = $payment?->taxDeductions?->toArray() ?? [];
            foreach ($this->taxRecords as $index => $taxRecord) {
                $matchingHead = $this->taxHeads->firstWhere('id', $taxRecord['name']);
                if ($matchingHead) {
                    $this->taxRecords[$index]['title'] = $matchingHead->title;
                }
            }
        }

        $this->resetTax();

        // Calculate derived advance values
        $this->calculateAdvanceDue();
        $this->calculateDeposit();

        // Implementation agency info
        $agency = null;

        switch ($model) {
            case ImplementationMethods::OperatedByTrust:
                $agency = $this->plan->implementationAgency?->application;
                break;

            case ImplementationMethods::OperatedByNGO:
            case ImplementationMethods::OperatedByContract:
            case ImplementationMethods::OperatedByQuotation:
                $agency = $this->plan->implementationAgency?->organization;
                break;

            case ImplementationMethods::OperatedByConsumerCommittee:
                $agency = $this->plan->implementationAgency?->consumerCommittee;
                break;
        }

        $this->payment['implementation_agency'] = $agency->name
            ?? $agency->applicant_name
            ?? '';

        $this->payment['implementation_agency_address'] = $agency->address ?? '';

        // Recalculate totals on load
        $this->calculateTotals();

        $this->dispatch('open-payment-tab');
    }
    private function resetForm()
    {
        $this->reset(['advancePayment', 'action']);
        $this->advancePayment = new AdvancePayment();
    }
}
