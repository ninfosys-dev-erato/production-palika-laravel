<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\ProjectInstallmentDetailAdminDto;
use Src\Yojana\Models\ProjectInstallmentDetail;
use Src\Yojana\Service\ProjectInstallmentDetailAdminService;

class ProjectInstallmentDetailForm extends Component
{
    use SessionFlash;

    public ?ProjectInstallmentDetail $projectInstallmentDetail;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'projectInstallmentDetail.project_id' => ['required'],
    'projectInstallmentDetail.installment_type' => ['required'],
    'projectInstallmentDetail.date' => ['required'],
    'projectInstallmentDetail.amount' => ['required'],
    'projectInstallmentDetail.construction_material_quantity' => ['required'],
    'projectInstallmentDetail.remarks' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'projectInstallmentDetail.project_id.required' => __('yojana::yojana.project_id_is_required'),
            'projectInstallmentDetail.installment_type.required' => __('yojana::yojana.installment_type_is_required'),
            'projectInstallmentDetail.date.required' => __('yojana::yojana.date_is_required'),
            'projectInstallmentDetail.amount.required' => __('yojana::yojana.amount_is_required'),
            'projectInstallmentDetail.construction_material_quantity.required' => __('yojana::yojana.construction_material_quantity_is_required'),
            'projectInstallmentDetail.remarks.required' => __('yojana::yojana.remarks_is_required'),
        ];
    }

    public function render(){
        return view("ProjectInstallmentDetails::livewire.form");
    }

    public function mount(ProjectInstallmentDetail $projectInstallmentDetail,Action $action)
    {
        $this->projectInstallmentDetail = $projectInstallmentDetail;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = ProjectInstallmentDetailAdminDto::fromLiveWireModel($this->projectInstallmentDetail);
        $service = new ProjectInstallmentDetailAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Project Installment Detail Created Successfully");
                return redirect()->route('admin.project_installment_details.index');
                break;
            case Action::UPDATE:
                $service->update($this->projectInstallmentDetail,$dto);
                $this->successFlash("Project Installment Detail Updated Successfully");
                return redirect()->route('admin.project_installment_details.index');
                break;
            default:
                return redirect()->route('admin.project_installment_details.index');
                break;
        }
    }
}
