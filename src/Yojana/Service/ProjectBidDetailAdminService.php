<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ProjectBidDetailAdminDto;
use Src\Yojana\Models\ProjectBidDetail;

class ProjectBidDetailAdminService
{
public function store(ProjectBidDetailAdminDto $projectBidDetailAdminDto){
    return ProjectBidDetail::create([
        'project_id' => $projectBidDetailAdminDto->project_id,
        'cost_estimation' => $projectBidDetailAdminDto->cost_estimation,
        'notice_published_date' => $projectBidDetailAdminDto->notice_published_date,
        'newspaper_name' => $projectBidDetailAdminDto->newspaper_name,
        'contract_evaluation_decision_date' => $projectBidDetailAdminDto->contract_evaluation_decision_date,
        'intent_notice_publish_date' => $projectBidDetailAdminDto->intent_notice_publish_date,
        'contract_newspaper_name' => $projectBidDetailAdminDto->contract_newspaper_name,
        'contract_acceptance_decision_date' => $projectBidDetailAdminDto->contract_acceptance_decision_date,
        'contract_percentage' => $projectBidDetailAdminDto->contract_percentage,
        'contractor_name' => $projectBidDetailAdminDto->contractor_name,
        'contractor_address' => $projectBidDetailAdminDto->contractor_address,
        'contractor_phone' => $projectBidDetailAdminDto->contractor_phone,
        'confession_number' => $projectBidDetailAdminDto->confession_number,
        'contract_agreement_date' => $projectBidDetailAdminDto->contract_agreement_date,
        'contract_assigned_date' => $projectBidDetailAdminDto->contract_assigned_date,
        'bid_bond_amount' => $projectBidDetailAdminDto->bid_bond_amount,
        'bid_bond_no' => $projectBidDetailAdminDto->bid_bond_no,
        'bid_bond_bank_name' => $projectBidDetailAdminDto->bid_bond_bank_name,
        'bid_bond_issue_date' => $projectBidDetailAdminDto->bid_bond_issue_date,
        'bid_bond_expiry_date' => $projectBidDetailAdminDto->bid_bond_expiry_date,
        'performance_bond_no' => $projectBidDetailAdminDto->performance_bond_no,
        'performance_bond_amount' => $projectBidDetailAdminDto->performance_bond_amount,
        'performance_bond_bank' => $projectBidDetailAdminDto->performance_bond_bank,
        'performance_bond_issue_date' => $projectBidDetailAdminDto->performance_bond_issue_date,
        'performance_bond_expiry_date' => $projectBidDetailAdminDto->performance_bond_expiry_date,
        'performance_bond_extended_date' => $projectBidDetailAdminDto->performance_bond_extended_date,
        'insurance_issue_date' => $projectBidDetailAdminDto->insurance_issue_date,
        'insurance_expiry_date' => $projectBidDetailAdminDto->insurance_expiry_date,
        'insurance_extended_date' => $projectBidDetailAdminDto->insurance_extended_date,
        'bid_no' => $projectBidDetailAdminDto->bid_no,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(ProjectBidDetail $projectBidDetail, ProjectBidDetailAdminDto $projectBidDetailAdminDto){
    return tap($projectBidDetail)->update([
        'project_id' => $projectBidDetailAdminDto->project_id,
        'cost_estimation' => $projectBidDetailAdminDto->cost_estimation,
        'notice_published_date' => $projectBidDetailAdminDto->notice_published_date,
        'newspaper_name' => $projectBidDetailAdminDto->newspaper_name,
        'contract_evaluation_decision_date' => $projectBidDetailAdminDto->contract_evaluation_decision_date,
        'intent_notice_publish_date' => $projectBidDetailAdminDto->intent_notice_publish_date,
        'contract_newspaper_name' => $projectBidDetailAdminDto->contract_newspaper_name,
        'contract_acceptance_decision_date' => $projectBidDetailAdminDto->contract_acceptance_decision_date,
        'contract_percentage' => $projectBidDetailAdminDto->contract_percentage,
        'contractor_name' => $projectBidDetailAdminDto->contractor_name,
        'contractor_address' => $projectBidDetailAdminDto->contractor_address,
        'contractor_phone' => $projectBidDetailAdminDto->contractor_phone,
        'confession_number' => $projectBidDetailAdminDto->confession_number,
        'contract_agreement_date' => $projectBidDetailAdminDto->contract_agreement_date,
        'contract_assigned_date' => $projectBidDetailAdminDto->contract_assigned_date,
        'bid_bond_amount' => $projectBidDetailAdminDto->bid_bond_amount,
        'bid_bond_no' => $projectBidDetailAdminDto->bid_bond_no,
        'bid_bond_bank_name' => $projectBidDetailAdminDto->bid_bond_bank_name,
        'bid_bond_issue_date' => $projectBidDetailAdminDto->bid_bond_issue_date,
        'bid_bond_expiry_date' => $projectBidDetailAdminDto->bid_bond_expiry_date,
        'performance_bond_no' => $projectBidDetailAdminDto->performance_bond_no,
        'performance_bond_amount' => $projectBidDetailAdminDto->performance_bond_amount,
        'performance_bond_bank' => $projectBidDetailAdminDto->performance_bond_bank,
        'performance_bond_issue_date' => $projectBidDetailAdminDto->performance_bond_issue_date,
        'performance_bond_expiry_date' => $projectBidDetailAdminDto->performance_bond_expiry_date,
        'performance_bond_extended_date' => $projectBidDetailAdminDto->performance_bond_extended_date,
        'insurance_issue_date' => $projectBidDetailAdminDto->insurance_issue_date,
        'insurance_expiry_date' => $projectBidDetailAdminDto->insurance_expiry_date,
        'insurance_extended_date' => $projectBidDetailAdminDto->insurance_extended_date,
        'bid_no' => $projectBidDetailAdminDto->bid_no,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(ProjectBidDetail $projectBidDetail){
    return tap($projectBidDetail)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    ProjectBidDetail::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


