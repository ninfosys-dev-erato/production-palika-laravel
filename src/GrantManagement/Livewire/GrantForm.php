<?php

namespace Src\GrantManagement\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\GrantManagement\Controllers\GrantAdminController;
use Src\GrantManagement\DTO\GrantAdminDto;
use Src\GrantManagement\Models\Grant;
use Src\GrantManagement\Service\GrantAdminService;

class GrantForm extends Component
{
    use SessionFlash;

    public ?Grant $grant;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'grant.fiscal_year_id' => ['required'],
    'grant.grant_type_id' => ['required'],
    'grant.grant_office_id' => ['required'],
    'grant.grant_program_name' => ['required'],
    'grant.branch_id' => ['required'],
    'grant.grant_amount' => ['required'],
    'grant.grant_for' => ['required'],
    'grant.main_activity' => ['required'],
    'grant.remarks' => ['required'],
    'grant.user_id' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'grant.fiscal_year_id.required' => __('grantmanagement::grantmanagement.fiscal_year_id_is_required'),
            'grant.grant_type_id.required' => __('grantmanagement::grantmanagement.grant_type_id_is_required'),
            'grant.grant_office_id.required' => __('grantmanagement::grantmanagement.grant_office_id_is_required'),
            'grant.grant_program_name.required' => __('grantmanagement::grantmanagement.grant_program_name_is_required'),
            'grant.branch_id.required' => __('grantmanagement::grantmanagement.branch_id_is_required'),
            'grant.grant_amount.required' => __('grantmanagement::grantmanagement.grant_amount_is_required'),
            'grant.grant_for.required' => __('grantmanagement::grantmanagement.grant_for_is_required'),
            'grant.main_activity.required' => __('grantmanagement::grantmanagement.main_activity_is_required'),
            'grant.remarks.required' => __('grantmanagement::grantmanagement.remarks_is_required'),
            'grant.user_id.required' => __('grantmanagement::grantmanagement.user_id_is_required'),
        ];
    }

    public function render(){
        return view("GrantManagement::livewire.grants-form");
    }

    public function mount(Grant $grant,Action $action)
    {
        $this->grant = $grant;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = GrantAdminDto::fromLiveWireModel($this->grant);
        $service = new GrantAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('grantmanagement::grantmanagement.grant_created_successfully'));
                return redirect()->route('admin.grants.index');
                break;
            case Action::UPDATE:
                $service->update($this->grant,$dto);
                $this->successFlash(__('grantmanagement::grantmanagement.grant_updated_successfully'));
                return redirect()->route('admin.grants.index');
                break;
            default:
                return redirect()->route('admin.grants.index');
                break;
        }
    }
}
