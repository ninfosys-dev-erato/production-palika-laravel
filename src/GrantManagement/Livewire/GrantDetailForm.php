<?php

namespace Src\GrantManagement\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\GrantManagement\Controllers\GrantDetailAdminController;
use Src\GrantManagement\DTO\GrantDetailAdminDto;
use Src\GrantManagement\Models\GrantDetail;
use Src\GrantManagement\Service\GrantDetailAdminService;

class GrantDetailForm extends Component
{
    use SessionFlash;

    public ?GrantDetail $grantDetail;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'grantDetail.grant_id' => ['required'],
    'grantDetail.grant_for' => ['required'],
    'grantDetail.model_type' => ['required'],
    'grantDetail.model_id' => ['required'],
    'grantDetail.personal_investment' => ['required'],
    'grantDetail.is_old' => ['required'],
    'grantDetail.prev_fiscal_year_id' => ['required'],
    'grantDetail.investment_amount' => ['required'],
    'grantDetail.remarks' => ['required'],
    'grantDetail.local_body_id' => ['required'],
    'grantDetail.ward_no' => ['required'],
    'grantDetail.village' => ['required'],
    'grantDetail.tole' => ['required'],
    'grantDetail.plot_no' => ['required'],
    'grantDetail.contact_person' => ['required'],
    'grantDetail.contact' => ['required'],
    'grantDetail.user_id' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'grantDetail.grant_id.required' => __('grantmanagement::grantmanagement.grant_id_is_required'),
            'grantDetail.grant_for.required' => __('grantmanagement::grantmanagement.grant_for_is_required'),
            'grantDetail.model_type.required' => __('grantmanagement::grantmanagement.model_type_is_required'),
            'grantDetail.model_id.required' => __('grantmanagement::grantmanagement.model_id_is_required'),
            'grantDetail.personal_investment.required' => __('grantmanagement::grantmanagement.personal_investment_is_required'),
            'grantDetail.is_old.required' => __('grantmanagement::grantmanagement.is_old_is_required'),
            'grantDetail.prev_fiscal_year_id.required' => __('grantmanagement::grantmanagement.prev_fiscal_year_id_is_required'),
            'grantDetail.investment_amount.required' => __('grantmanagement::grantmanagement.investment_amount_is_required'),
            'grantDetail.remarks.required' => __('grantmanagement::grantmanagement.remarks_is_required'),
            'grantDetail.local_body_id.required' => __('grantmanagement::grantmanagement.local_body_id_is_required'),
            'grantDetail.ward_no.required' => __('grantmanagement::grantmanagement.ward_no_is_required'),
            'grantDetail.village.required' => __('grantmanagement::grantmanagement.village_is_required'),
            'grantDetail.tole.required' => __('grantmanagement::grantmanagement.tole_is_required'),
            'grantDetail.plot_no.required' => __('grantmanagement::grantmanagement.plot_no_is_required'),
            'grantDetail.contact_person.required' => __('grantmanagement::grantmanagement.contact_person_is_required'),
            'grantDetail.contact.required' => __('grantmanagement::grantmanagement.contact_is_required'),
            'grantDetail.user_id.required' => __('grantmanagement::grantmanagement.user_id_is_required'),
        ];
    }

    public function render(){
        return view("GrantManagement::livewire.grant-details-form");
    }

    public function mount(GrantDetail $grantDetail,Action $action)
    {
        $this->grantDetail = $grantDetail;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = GrantDetailAdminDto::fromLiveWireModel($this->grantDetail);
        $service = new GrantDetailAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('grantmanagement::grantmanagement.grant_detail_created_successfully'));
                return redirect()->route('admin.grant_details.index');
                break;
            case Action::UPDATE:
                $service->update($this->grantDetail,$dto);
                $this->successFlash(__('grantmanagement::grantmanagement.grant_detail_updated_successfully'));
                return redirect()->route('admin.grant_details.index');
                break;
            default:
                return redirect()->route('admin.grant_details.index');
                break;
        }
    }
}
