<?php

namespace Src\Yojana\Livewire;

use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Rappasoft\LaravelLivewireTables\Traits\Core\Component\HandlesOfflineIndicator;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Src\Yojana\Enums\LetterTypes;
use Src\Yojana\Models\Payment;
use Src\Yojana\Models\Plan;
use Src\Yojana\Service\PaymentAdminService;
use Src\Yojana\Service\WorkOrderAdminService;

class PaymentsTable extends Component
{
    use SessionFlash,HelperDate;
    public $payments;
    public ?Plan $plan;

    public function mount(Plan $plan)
    {
        $this->plan = $plan;

        $this->payments = Payment::query()
            ->select('*')
            ->when(!empty($this->plan?->id), fn($query) =>
            $query->where('plan_id', $this->plan->id)
            )
            ->with(['plan', 'evaluation'])
            ->whereNull('deleted_at')
            ->whereNull('deleted_by')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($payment) {
                // Process agreement_date
                $agreementDate = $payment->plan->agreement_date ?? null;
                if ($agreementDate && strtotime($agreementDate)) {
                    try {
                        $bs = $this->adToBs($agreementDate);
                        $payment->agreement_date_bs = $bs ? replaceNumbers($bs, true) : '-';
                    } catch (\Throwable $e) {
                        $payment->agreement_date_bs = '-';
                    }
                } else {
                    $payment->agreement_date_bs = '-';
                }

                // Process completion_date
                $completionDate = $payment->evaluation->completion_date ?? null;
                if ($completionDate && strtotime($completionDate)) {
                    try {
                        $bs = $this->adToBs($completionDate);
                        $payment->completion_date_bs = $bs ? replaceNumbers($bs, true) : '-';
                    } catch (\Throwable $e) {
                        $payment->completion_date_bs = '-';
                    }
                } else {
                    $payment->completion_date_bs = '-';
                }

                return $payment;
            });
    }

    public function render()
    {
        return view('Yojana::livewire.payments-table');
    }

    public function delete($id)
    {
        if(!can('payments delete')){
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new PaymentAdminService();
        $service->delete(Payment::findOrFail($id));
        $this->successFlash(__('yojana::yojana.payment_deleted_successfully'));
    }

    public function edit($id)
    {
        if(!can('payments edit')){
            SessionFlash::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $this->dispatch('edit-payment',$id);
    }

    public function printWorkOrder($id)
    {
        $service = new PaymentAdminService();
        $workOrder = $service->getWorkOrder($id);
        if (!isset($workOrder)){
            $this->errorFlash('Template Not Found');
            return false;
        }
        $url = route('admin.plans.work_orders.preview',['id'=>$workOrder->id,'model_id'=>$id]);
        $this->dispatch('open-pdf-in-new-tab', url: $url);
    }

}
