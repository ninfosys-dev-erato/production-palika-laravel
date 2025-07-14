<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\ProjectGrantDetailAdminDto;
use Src\Yojana\Models\ProjectGrantDetail;
use Src\Yojana\Service\ProjectGrantDetailAdminService;

class ProjectGrantDetailForm extends Component
{
    use SessionFlash;

    public ?ProjectGrantDetail $projectGrantDetail;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'projectGrantDetail.project_id' => ['required'],
    'projectGrantDetail.grant_source' => ['required'],
    'projectGrantDetail.asset_name' => ['required'],
    'projectGrantDetail.quantity' => ['required'],
    'projectGrantDetail.asset_unit' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'projectGrantDetail.project_id.required' => __('yojana::yojana.project_id_is_required'),
            'projectGrantDetail.grant_source.required' => __('yojana::yojana.grant_source_is_required'),
            'projectGrantDetail.asset_name.required' => __('yojana::yojana.asset_name_is_required'),
            'projectGrantDetail.quantity.required' => __('yojana::yojana.quantity_is_required'),
            'projectGrantDetail.asset_unit.required' => __('yojana::yojana.asset_unit_is_required'),
        ];
    }

    public function render(){
        return view("ProjectGrantDetails::projects.form");
    }

    public function mount(ProjectGrantDetail $projectGrantDetail,Action $action)
    {
        $this->projectGrantDetail = $projectGrantDetail;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = ProjectGrantDetailAdminDto::fromLiveWireModel($this->projectGrantDetail);
        $service = new ProjectGrantDetailAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Project Grant Detail Created Successfully");
                return redirect()->route('admin.project_grant_details.index');
                break;
            case Action::UPDATE:
                $service->update($this->projectGrantDetail,$dto);
                $this->successFlash("Project Grant Detail Updated Successfully");
                return redirect()->route('admin.project_grant_details.index');
                break;
            default:
                return redirect()->route('admin.project_grant_details.index');
                break;
        }
    }
}
