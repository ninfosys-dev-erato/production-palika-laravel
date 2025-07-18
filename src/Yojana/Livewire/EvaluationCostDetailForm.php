<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\Controllers\EvaluationCostDetailAdminController;
use Src\Yojana\DTO\EvaluationCostDetailAdminDto;
use Src\Yojana\Models\EvaluationCostDetail;
use Src\Yojana\Service\EvaluationCostDetailAdminService;

class EvaluationCostDetailForm extends Component
{
    use SessionFlash;

    public ?EvaluationCostDetail $evaluationCostDetail;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'evaluationCostDetail.evaluation_id' => ['required'],
    'evaluationCostDetail.activity_id' => ['required'],
    'evaluationCostDetail.unit' => ['required'],
    'evaluationCostDetail.agreement' => ['required'],
    'evaluationCostDetail.before_this' => ['required'],
    'evaluationCostDetail.up_to_date_amount' => ['required'],
    'evaluationCostDetail.current' => ['required'],
    'evaluationCostDetail.rate' => ['required'],
    'evaluationCostDetail.assessment_amount' => ['required'],
    'evaluationCostDetail.vat_amount' => ['required'],
];
    }

    public function render(){
        return view("Yojana::livewire.evaluation-cost-details-form");
    }

    public function mount(EvaluationCostDetail $evaluationCostDetail,Action $action)
    {
        $this->evaluationCostDetail = $evaluationCostDetail;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = EvaluationCostDetailAdminDto::fromLiveWireModel($this->evaluationCostDetail);
        $service = new EvaluationCostDetailAdminService();
        switch ($this->action){
            case Action::CREATE:
                $created = $service->store($dto);
                if($created instanceof EvaluationCostDetail){
                    $this->successFlash(__('yojana::yojana.evaluation_cost_detail_created_successfully'));
                }else{
                    $this->errorFlash(__('yojana::yojana.evaluation_cost_detail_failed_to_create'));
                }
                return redirect()->route('admin.evaluation_cost_details.index');
            case Action::UPDATE:
                $updated = $service->update($this->evaluationCostDetail, $dto);
                if ($updated instanceof EvaluationCostDetail) {
                    $this->successFlash(__('yojana::yojana.evaluation_cost_detail_updated_successfully'));
                } else {
                    $this->errorFlash(__('yojana::yojana.evaluation_cost_detail_failed_to_update'));
                }
                return redirect()->route('admin.evaluation_cost_details.index');
            default:
                $this->errorFlash(__('yojana::yojana.invalid_action'));
                break;
        }
    }
}
