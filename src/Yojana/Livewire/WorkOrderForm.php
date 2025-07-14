<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\WorkOrderAdminDto;
use Src\Yojana\Models\Plan;
use Src\Yojana\Models\WorkOrder;
use Src\Yojana\Service\WorkOrderAdminService;
use Livewire\Attributes\On;

class WorkOrderForm extends Component
{
    use SessionFlash;

    public ?WorkOrder $workOrder;
    public ?Action $action = Action::CREATE;
    public $plan;


    public function rules(): array
    {
        return [
            'workOrder.date' => ['required'],
            'workOrder.plan_id' => ['required'],
            'workOrder.plan_name' => ['required'],
            'workOrder.subject' => ['required'],
            'workOrder.letter_body' => ['nullable'],
        ];
    }
    public function messages(): array
    {
        return [
            'workOrder.date.required' => __('yojana::yojana.date_is_required'),
            'workOrder.plan_id.required' => __('yojana::yojana.plan_id_is_required'),
            'workOrder.plan_name.required' => __('yojana::yojana.plan_name_is_required'),
            'workOrder.subject.required' => __('yojana::yojana.subject_is_required'),
            'workOrder.letter_body.nullable' => __('yojana::yojana.letter_body_is_optional'),
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.work-order.form");
    }

    public function mount(WorkOrder $workOrder, Action $action,Plan $plan)
    {
        $this->workOrder = $workOrder;
        $this->action = $action;
        $this->plan = $plan;

        $this->workOrder->plan_name = $plan->project_name;


    }

    public function save()
    {
        $this->workOrder->plan_id = $this->plan->id;
        $this->validate();
        $dto = WorkOrderAdminDto::fromLiveWireModel($this->workOrder);
        $service = new WorkOrderAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.work_order_created_successfully'));
                // return redirect()->route('admin.work_orders.index');
                break;
            case Action::UPDATE:
                $service->update($this->workOrder, $dto);
                $this->successFlash(__('yojana::yojana.work_order_updated_successfully'));
                // return redirect()->route('admin.work_orders.index');
                break;
            default:
                return redirect()->route('admin.plans.work_orders.index');
                break;
        }
        $this->dispatch('close-modal', id: 'workOrderModal');
    }


    #[On('workOrder-edit')]
    public function editWorkOrder(WorkOrder $workOrder)
    {
        $this->workOrder = $workOrder;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal', id: 'workOrderModal');
    }
    #[On('reset-form')]
    public function resetWorkOrder()
    {
        $this->reset(['workOrder', 'action']);
        $this->workOrder = new WorkOrder();
        $this->workOrder->plan_name = $this->plan->project_name;
    }

}
