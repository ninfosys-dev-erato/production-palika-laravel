<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\TechnicalCostEstimateAdminDto;
use Src\Yojana\Models\TechnicalCostEstimate;
use Src\Yojana\Service\TechnicalCostEstimateAdminService;

class TechnicalCostEstimateForm extends Component
{
    use SessionFlash;

    public ?TechnicalCostEstimate $technicalCostEstimate;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'technicalCostEstimate.project_id' => ['required'],
    'technicalCostEstimate.detail' => ['required'],
    'technicalCostEstimate.quantity' => ['required'],
    'technicalCostEstimate.unit_id' => ['required'],
    'technicalCostEstimate.rate' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'technicalCostEstimate.project_id.required' => __('yojana::yojana.project_id_is_required'),
            'technicalCostEstimate.detail.required' => __('yojana::yojana.detail_is_required'),
            'technicalCostEstimate.quantity.required' => __('yojana::yojana.quantity_is_required'),
            'technicalCostEstimate.unit_id.required' => __('yojana::yojana.unit_id_is_required'),
            'technicalCostEstimate.rate.required' => __('yojana::yojana.rate_is_required'),
        ];
    }

    public function render(){
        return view("TechnicalCostEstimates::livewire.form");
    }

    public function mount(TechnicalCostEstimate $technicalCostEstimate,Action $action)
    {
        $this->technicalCostEstimate = $technicalCostEstimate;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = TechnicalCostEstimateAdminDto::fromLiveWireModel($this->technicalCostEstimate);
        $service = new TechnicalCostEstimateAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Technical Cost Estimate Created Successfully");
                return redirect()->route('admin.technical_cost_estimates.index');
                break;
            case Action::UPDATE:
                $service->update($this->technicalCostEstimate,$dto);
                $this->successFlash("Technical Cost Estimate Updated Successfully");
                return redirect()->route('admin.technical_cost_estimates.index');
                break;
            default:
                return redirect()->route('admin.technical_cost_estimates.index');
                break;
        }
    }
}
