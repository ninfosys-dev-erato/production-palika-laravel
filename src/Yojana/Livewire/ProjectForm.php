<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\ProjectAdminDto;
use Src\Yojana\Models\Project;
use Src\Yojana\Service\ProjectAdminService;

class ProjectForm extends Component
{
    use SessionFlash;

    public ?Project $project;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'project.registration_no' => ['required'],
    'project.fiscal_year_id' => ['required'],
    'project.project_name' => ['required'],
    'project.plan_area_id' => ['required'],
    'project.project_status' => ['required'],
    'project.project_start_date' => ['required'],
    'project.project_completion_date' => ['required'],
    'project.plan_level_id' => ['required'],
    'project.ward_no' => ['required'],
    'project.allocated_amount' => ['required'],
    'project.project_venue' => ['required'],
    'project.evaluation_amount' => ['required'],
    'project.purpose' => ['required'],
    'project.operated_through' => ['required'],
    'project.progress_spent_amount' => ['required'],
    'project.physical_progress_target' => ['required'],
    'project.physical_progress_completed' => ['required'],
    'project.physical_progress_unit' => ['required'],
    'project.first_quarterly_amount' => ['required'],
    'project.first_quarterly_goal' => ['required'],
    'project.second_quarterly_amount' => ['required'],
    'project.second_quarterly_goal' => ['required'],
    'project.third_quarterly_amount' => ['required'],
    'project.third_quarterly_goal' => ['required'],
    'project.agencies_grants' => ['required'],
    'project.share_amount' => ['required'],
    'project.committee_share_amount' => ['required'],
    'project.labor_amount' => ['required'],
    'project.benefited_organization' => ['required'],
    'project.others_benefited' => ['required'],
    'project.expense_head_id' => ['required'],
    'project.contingency_amount' => ['required'],
    'project.other_taxes' => ['required'],
    'project.is_contracted' => ['required'],
    'project.contract_date' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'project.registration_no.required' => __('yojana::yojana.registration_no_is_required'),
            'project.fiscal_year_id.required' => __('yojana::yojana.fiscal_year_id_is_required'),
            'project.project_name.required' => __('yojana::yojana.project_name_is_required'),
            'project.plan_area_id.required' => __('yojana::yojana.plan_area_id_is_required'),
            'project.project_status.required' => __('yojana::yojana.project_status_is_required'),
            'project.project_start_date.required' => __('yojana::yojana.project_start_date_is_required'),
            'project.project_completion_date.required' => __('yojana::yojana.project_completion_date_is_required'),
            'project.plan_level_id.required' => __('yojana::yojana.plan_level_id_is_required'),
            'project.ward_no.required' => __('yojana::yojana.ward_no_is_required'),
            'project.allocated_amount.required' => __('yojana::yojana.allocated_amount_is_required'),
            'project.project_venue.required' => __('yojana::yojana.project_venue_is_required'),
            'project.evaluation_amount.required' => __('yojana::yojana.evaluation_amount_is_required'),
            'project.purpose.required' => __('yojana::yojana.purpose_is_required'),
            'project.operated_through.required' => __('yojana::yojana.operated_through_is_required'),
            'project.progress_spent_amount.required' => __('yojana::yojana.progress_spent_amount_is_required'),
            'project.physical_progress_target.required' => __('yojana::yojana.physical_progress_target_is_required'),
            'project.physical_progress_completed.required' => __('yojana::yojana.physical_progress_completed_is_required'),
            'project.physical_progress_unit.required' => __('yojana::yojana.physical_progress_unit_is_required'),
            'project.first_quarterly_amount.required' => __('yojana::yojana.first_quarterly_amount_is_required'),
            'project.first_quarterly_goal.required' => __('yojana::yojana.first_quarterly_goal_is_required'),
            'project.second_quarterly_amount.required' => __('yojana::yojana.second_quarterly_amount_is_required'),
            'project.second_quarterly_goal.required' => __('yojana::yojana.second_quarterly_goal_is_required'),
            'project.third_quarterly_amount.required' => __('yojana::yojana.third_quarterly_amount_is_required'),
            'project.third_quarterly_goal.required' => __('yojana::yojana.third_quarterly_goal_is_required'),
            'project.agencies_grants.required' => __('yojana::yojana.agencies_grants_is_required'),
            'project.share_amount.required' => __('yojana::yojana.share_amount_is_required'),
            'project.committee_share_amount.required' => __('yojana::yojana.committee_share_amount_is_required'),
            'project.labor_amount.required' => __('yojana::yojana.labor_amount_is_required'),
            'project.benefited_organization.required' => __('yojana::yojana.benefited_organization_is_required'),
            'project.others_benefited.required' => __('yojana::yojana.others_benefited_is_required'),
            'project.expense_head_id.required' => __('yojana::yojana.expense_head_id_is_required'),
            'project.contingency_amount.required' => __('yojana::yojana.contingency_amount_is_required'),
            'project.other_taxes.required' => __('yojana::yojana.other_taxes_is_required'),
            'project.is_contracted.required' => __('yojana::yojana.is_contracted_is_required'),
            'project.contract_date.required' => __('yojana::yojana.contract_date_is_required'),
        ];
    }

    public function render(){
        return view("Projects::projects.form");
    }

    public function mount(Project $project,Action $action)
    {
        $this->project = $project;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = ProjectAdminDto::fromLiveWireModel($this->project);
        $service = new ProjectAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.project_created_successfully'));
                return redirect()->route('admin.projects.index');
                break;
            case Action::UPDATE:
                $service->update($this->project,$dto);
                $this->successFlash(__('yojana::yojana.project_updated_successfully'));
                return redirect()->route('admin.projects.index');
                break;
            default:
                return redirect()->route('admin.projects.index');
                break;
        }
    }
}
