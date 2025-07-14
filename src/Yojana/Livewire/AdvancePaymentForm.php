<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\Yojana\DTO\AdvancePaymentAdminDto;
use Src\Yojana\Enums\Installments;
use Src\Yojana\Enums\PlanStatus;
use Src\Yojana\Models\AdvancePayment;
use Src\Yojana\Models\Plan;
use Src\Yojana\Service\AdvancePaymentAdminService;

class AdvancePaymentForm extends Component
{
    use SessionFlash;

    public ?AdvancePayment $advancePayment;
    public ?Action $action = Action::CREATE;
    public ?Plan $plan;
    public $installments;

    public function rules(): array
    {
        return [
            'advancePayment.installment' => ['required'],
            'advancePayment.date' => ['required'],
            'advancePayment.clearance_date' => ['required'],
            'advancePayment.advance_deposit_number' => ['required'],
            'advancePayment.paid_amount' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'advancePayment.installment.required' => __('yojana::yojana.installment_is_required'),
            'advancePayment.date.required' => __('yojana::yojana.date_is_required'),
            'advancePayment.clearance_date.required' => __('yojana::yojana.clearance_date_is_required'),
            'advancePayment.advance_deposit_number.required' => __('yojana::yojana.advance_deposit_number_is_required'),
            'advancePayment.paid_amount.required' => __('yojana::yojana.paid_amount_is_required'),
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.advance-payments.form");
    }

    public function mount(AdvancePayment $advancePayment, Plan $plan, Action $action)
    {
        $this->plan = $plan;
        $this->action = $action;
        $this->advancePayment = $advancePayment;
        $this->installments = Installments::getForWeb();
    }

    public function save()
    {
        $this->validate();
        try {
            $this->advancePayment->plan_id = $this->plan->id;
            $dto = AdvancePaymentAdminDto::fromLiveWireModel($this->advancePayment);
            $service = new AdvancePaymentAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->plan->status = PlanStatus::AdvancePaymentCompleted;
                    $this->plan->save();
                    $this->successFlash(__('yojana::yojana.advance_payment_created_successfully'));
                    $this->dispatch('reload_page');
                    break;
                case Action::UPDATE:
                    $service->update($this->advancePayment, $dto);
                    $this->successFlash(__('yojana::yojana.advance_payment_updated_successfully'));
                    $this->dispatch('reload_page');
                    break;
                default:
                    break;
            }
            $this->dispatch('close-modal', id: 'indexModal3');
        } catch (ValidationException $e) {
            //            dd($e->errors());
            $this->errorFlash(collect($e->errors())->flatten()->first());
        } catch (\Exception $e) {
            //            dd($e->getMessage());
            $this->errorFlash(collect($e)->flatten()->first());
        }
    }

    #[On('edit-advance-payment')]
    public function editBudgetHead(AdvancePayment $advancePayment)
    {
        $this->advancePayment = $advancePayment;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal', id: 'indexModal3');
    }
    private function resetForm()
    {
        $this->reset(['advancePayment', 'action']);
        $this->advancePayment = new AdvancePayment();
    }
    #[On('reset-form')]
    public function resetBudgetHead()
    {
        $this->resetForm();
    }
}
