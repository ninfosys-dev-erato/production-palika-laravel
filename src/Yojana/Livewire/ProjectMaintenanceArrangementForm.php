<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\ProjectMaintenanceArrangementAdminDto;
use Src\Yojana\Models\ProjectMaintenanceArrangement;
use Src\Yojana\Service\ProjectMaintenanceArrangementAdminService;

class ProjectMaintenanceArrangementForm extends Component
{
    use SessionFlash;

    public ?ProjectMaintenanceArrangement $projectMaintenanceArrangement;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'projectMaintenanceArrangement.project_id' => ['required'],
    'projectMaintenanceArrangement.office_name' => ['required'],
    'projectMaintenanceArrangement.public_service' => ['required'],
    'projectMaintenanceArrangement.service_fee' => ['required'],
    'projectMaintenanceArrangement.from_fee_donation' => ['required'],
    'projectMaintenanceArrangement.others' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'projectMaintenanceArrangement.project_id.required' => __('yojana::yojana.project_id_is_required'),
            'projectMaintenanceArrangement.office_name.required' => __('yojana::yojana.office_name_is_required'),
            'projectMaintenanceArrangement.public_service.required' => __('yojana::yojana.public_service_is_required'),
            'projectMaintenanceArrangement.service_fee.required' => __('yojana::yojana.service_fee_is_required'),
            'projectMaintenanceArrangement.from_fee_donation.required' => __('yojana::yojana.from_fee_donation_is_required'),
            'projectMaintenanceArrangement.others.required' => __('yojana::yojana.others_is_required'),
        ];
    }

    public function render(){
        return view("ProjectMaintenanceArrangements::projects.form");
    }

    public function mount(ProjectMaintenanceArrangement $projectMaintenanceArrangement,Action $action)
    {
        $this->projectMaintenanceArrangement = $projectMaintenanceArrangement;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = ProjectMaintenanceArrangementAdminDto::fromLiveWireModel($this->projectMaintenanceArrangement);
        $service = new ProjectMaintenanceArrangementAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Project Maintenance Arrangement Created Successfully");
                return redirect()->route('admin.project_maintenance_arrangements.index');
                break;
            case Action::UPDATE:
                $service->update($this->projectMaintenanceArrangement,$dto);
                $this->successFlash("Project Maintenance Arrangement Updated Successfully");
                return redirect()->route('admin.project_maintenance_arrangements.index');
                break;
            default:
                return redirect()->route('admin.project_maintenance_arrangements.index');
                break;
        }
    }
}
