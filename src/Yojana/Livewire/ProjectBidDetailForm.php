<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\ProjectBidDetailAdminDto;
use Src\Yojana\Models\ProjectBidDetail;
use Src\Yojana\Service\ProjectBidDetailAdminService;

class ProjectBidDetailForm extends Component
{
    use SessionFlash;

    public ?ProjectBidDetail $projectBidDetail;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'projectBidDetail.project_id' => ['required'],
    'projectBidDetail.cost_estimation' => ['required'],
    'projectBidDetail.notice_published_date' => ['required'],
    'projectBidDetail.newspaper_name' => ['required'],
    'projectBidDetail.contract_evaluation_decision_date' => ['required'],
    'projectBidDetail.intent_notice_publish_date' => ['required'],
    'projectBidDetail.contract_newspaper_name' => ['required'],
    'projectBidDetail.contract_acceptance_decision_date' => ['required'],
    'projectBidDetail.contract_percentage' => ['required'],
    'projectBidDetail.contractor_name' => ['required'],
    'projectBidDetail.contractor_address' => ['required'],
    'projectBidDetail.contractor_phone' => ['required'],
    'projectBidDetail.confession_number' => ['required'],
    'projectBidDetail.contract_agreement_date' => ['required'],
    'projectBidDetail.contract_assigned_date' => ['required'],
    'projectBidDetail.bid_bond_amount' => ['required'],
    'projectBidDetail.bid_bond_no' => ['required'],
    'projectBidDetail.bid_bond_bank_name' => ['required'],
    'projectBidDetail.bid_bond_issue_date' => ['required'],
    'projectBidDetail.bid_bond_expiry_date' => ['required'],
    'projectBidDetail.performance_bond_no' => ['required'],
    'projectBidDetail.performance_bond_amount' => ['required'],
    'projectBidDetail.performance_bond_bank' => ['required'],
    'projectBidDetail.performance_bond_issue_date' => ['required'],
    'projectBidDetail.performance_bond_expiry_date' => ['required'],
    'projectBidDetail.performance_bond_extended_date' => ['required'],
    'projectBidDetail.insurance_issue_date' => ['required'],
    'projectBidDetail.insurance_expiry_date' => ['required'],
    'projectBidDetail.insurance_extended_date' => ['required'],
    'projectBidDetail.bid_no' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'projectBidDetail.project_id.required' => __('yojana::yojana.project_id_is_required'),
            'projectBidDetail.cost_estimation.required' => __('yojana::yojana.cost_estimation_is_required'),
            'projectBidDetail.notice_published_date.required' => __('yojana::yojana.notice_published_date_is_required'),
            'projectBidDetail.newspaper_name.required' => __('yojana::yojana.newspaper_name_is_required'),
            'projectBidDetail.contract_evaluation_decision_date.required' => __('yojana::yojana.contract_evaluation_decision_date_is_required'),
            'projectBidDetail.intent_notice_publish_date.required' => __('yojana::yojana.intent_notice_publish_date_is_required'),
            'projectBidDetail.contract_newspaper_name.required' => __('yojana::yojana.contract_newspaper_name_is_required'),
            'projectBidDetail.contract_acceptance_decision_date.required' => __('yojana::yojana.contract_acceptance_decision_date_is_required'),
            'projectBidDetail.contract_percentage.required' => __('yojana::yojana.contract_percentage_is_required'),
            'projectBidDetail.contractor_name.required' => __('yojana::yojana.contractor_name_is_required'),
            'projectBidDetail.contractor_address.required' => __('yojana::yojana.contractor_address_is_required'),
            'projectBidDetail.contractor_phone.required' => __('yojana::yojana.contractor_phone_is_required'),
            'projectBidDetail.confession_number.required' => __('yojana::yojana.confession_number_is_required'),
            'projectBidDetail.contract_agreement_date.required' => __('yojana::yojana.contract_agreement_date_is_required'),
            'projectBidDetail.contract_assigned_date.required' => __('yojana::yojana.contract_assigned_date_is_required'),
            'projectBidDetail.bid_bond_amount.required' => __('yojana::yojana.bid_bond_amount_is_required'),
            'projectBidDetail.bid_bond_no.required' => __('yojana::yojana.bid_bond_no_is_required'),
            'projectBidDetail.bid_bond_bank_name.required' => __('yojana::yojana.bid_bond_bank_name_is_required'),
            'projectBidDetail.bid_bond_issue_date.required' => __('yojana::yojana.bid_bond_issue_date_is_required'),
            'projectBidDetail.bid_bond_expiry_date.required' => __('yojana::yojana.bid_bond_expiry_date_is_required'),
            'projectBidDetail.performance_bond_no.required' => __('yojana::yojana.performance_bond_no_is_required'),
            'projectBidDetail.performance_bond_amount.required' => __('yojana::yojana.performance_bond_amount_is_required'),
            'projectBidDetail.performance_bond_bank.required' => __('yojana::yojana.performance_bond_bank_is_required'),
            'projectBidDetail.performance_bond_issue_date.required' => __('yojana::yojana.performance_bond_issue_date_is_required'),
            'projectBidDetail.performance_bond_expiry_date.required' => __('yojana::yojana.performance_bond_expiry_date_is_required'),
            'projectBidDetail.performance_bond_extended_date.required' => __('yojana::yojana.performance_bond_extended_date_is_required'),
            'projectBidDetail.insurance_issue_date.required' => __('yojana::yojana.insurance_issue_date_is_required'),
            'projectBidDetail.insurance_expiry_date.required' => __('yojana::yojana.insurance_expiry_date_is_required'),
            'projectBidDetail.insurance_extended_date.required' => __('yojana::yojana.insurance_extended_date_is_required'),
            'projectBidDetail.bid_no.required' => __('yojana::yojana.bid_no_is_required'),
        ];
    }

    public function render(){
        return view("ProjectBidDetails::projects.form");
    }

    public function mount(ProjectBidDetail $projectBidDetail,Action $action)
    {
        $this->projectBidDetail = $projectBidDetail;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = ProjectBidDetailAdminDto::fromLiveWireModel($this->projectBidDetail);
        $service = new ProjectBidDetailAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Project Bid Detail Created Successfully");
                return redirect()->route('admin.project_bid_details.index');
                break;
            case Action::UPDATE:
                $service->update($this->projectBidDetail,$dto);
                $this->successFlash("Project Bid Detail Updated Successfully");
                return redirect()->route('admin.project_bid_details.index');
                break;
            default:
                return redirect()->route('admin.project_bid_details.index');
                break;
        }
    }
}
