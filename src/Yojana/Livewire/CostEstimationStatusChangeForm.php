<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\Employees\Models\Employee;
use Src\Yojana\DTO\CostEstimationLogAdminDto;
use Src\Yojana\Enums\PlanStatus;
use Src\Yojana\Models\CostEstimation;
use Src\Yojana\Models\CostEstimationLog;
use Src\Yojana\Models\Plan;
use Src\Yojana\Service\CostEstimationLogAdminService;

class CostEstimationStatusChangeForm extends Component
{
    use SessionFlash;

    public ?CostEstimationLog $costEstimationLog;
    public ?Action $action = Action::CREATE;
    public ?Plan $plan;
    public ?CostEstimation $costEstimation;
    public $employees;
    public function rules(): array
    {
        return [
            'costEstimationLog.cost_estimation_id' => ['required'],
            'costEstimationLog.status' => ['required'],
            'costEstimationLog.forwarded_to' => ['required'],
            'costEstimationLog.remarks' => ['nullable'],
            'costEstimationLog.date' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'costEstimationLog.cost_estimation_id.required' => __('yojana::yojana.cost_estimation_id_is_required'),
            'costEstimationLog.status.required' => __('yojana::yojana.status_is_required'),
            'costEstimationLog.forwarded_to.required' => __('yojana::yojana.forwarded_to_is_required'),
            'costEstimationLog.remarks.nullable' => __('yojana::yojana.remarks_is_optional'),
            'costEstimationLog.date.required' => __('yojana::yojana.date_is_required'),
        ];
    }

    public function render(){
        return view("Yojana::livewire.cost-estimation.status-change-form");
    }

    public function mount(CostEstimationLog $costEstimationLog, Plan $plan, Action $action)
    {
        $this->plan = $plan;
        $this->action = $action;
        $this->costEstimationLog = $costEstimationLog;
        $this->costEstimation = $this->plan->costEstimation;
        $this->employees = Employee::whereNull('deleted_at')->get();
        $this->costEstimationLog->date = now()->format('d-m-Y');

        if (isset($this->costEstimation)) {
            if (empty($this->costEstimation->status)) {
                $this->costEstimation->status = 'Sent For Review';
                $this->costEstimationLog->status = $this->costEstimation->status;
            }
        }

//        dd($this->costEstimation->status);
    }

    public function save()
    {
        $this->costEstimationLog->cost_estimation_id = $this?->costEstimation->id??null;
        $this->validate();
        try{
            DB::beginTransaction();
            $this->costEstimation->status = $this->costEstimationLog->status;
            $this->costEstimation->save();
            $dto = CostEstimationLogAdminDto::fromLiveWireModel($this->costEstimationLog);
            $service = new CostEstimationLogAdminService();
            switch ($this->action){
                case Action::CREATE:
                    $service->store($dto);
                    if($this->costEstimation->status == "Approved"){
                        if ($this->plan->status == PlanStatus::TargetEntry){
                            $this->plan->status = PlanStatus::CostEstimationApproved;
                            $this->plan->save();
                        }
                        $this->dispatch('reload_page');
                    }
                    DB::commit();
                    $this->successFlash(__('yojana::yojana.status_changed_successfully'));
                    $this->resetForm();
                    break;
                case Action::UPDATE:
                    $service->update($this->costEstimationLog,$dto);
                    if($this->costEstimation->status == "Approved"){
                        $this->dispatch('reload_page');

                    }
                    DB::commit();
                    $this->successFlash(__('yojana::yojana.status_updated_successfully'));
                    break;
                default:
                    break;
            }
            $this->dispatch('close-modal', id:'costEstimationForwardModal');
        } catch (ValidationException $e) {
            DB::rollBack();
            $this->errorFlash(collect($e->errors())->flatten()->first());
        } catch (\Exception $e) {
            DB::rollBack();
            $this->errorFlash(collect($e)->flatten()->first());
        }
    }

    public function setStatus($newStatus)
    {
        $this->costEstimationLog->status = $newStatus;
    }

    private function resetForm()
    {
        $this->reset(['costEstimationLog', 'action']);
        $this->costEstimationLog = new CostEstimationLog();
        $this->costEstimationLog->date = now()->format('d-m-Y');
        if (empty($this->costEstimation->status)) {
            $this->costEstimationLog->status = 'Sent For Review';
        }

    }
    #[On('reset-form')]
    public function resetCostEstimationLog()
    {
        $this->resetForm();
    }
}
