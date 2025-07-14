<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\ProjectBidDetail;

class ProjectBidDetailAdminDto
{
   public function __construct(
        public string $project_id,
        public string $cost_estimation,
        public string $notice_published_date,
        public string $newspaper_name,
        public string $contract_evaluation_decision_date,
        public string $intent_notice_publish_date,
        public string $contract_newspaper_name,
        public string $contract_acceptance_decision_date,
        public string $contract_percentage,
        public string $contractor_name,
        public string $contractor_address,
        public string $contractor_phone,
        public string $confession_number,
        public string $contract_agreement_date,
        public string $contract_assigned_date,
        public string $bid_bond_amount,
        public string $bid_bond_no,
        public string $bid_bond_bank_name,
        public string $bid_bond_issue_date,
        public string $bid_bond_expiry_date,
        public string $performance_bond_no,
        public string $performance_bond_amount,
        public string $performance_bond_bank,
        public string $performance_bond_issue_date,
        public string $performance_bond_expiry_date,
        public string $performance_bond_extended_date,
        public string $insurance_issue_date,
        public string $insurance_expiry_date,
        public string $insurance_extended_date,
        public string $bid_no
    ){}

public static function fromLiveWireModel(ProjectBidDetail $projectBidDetail):ProjectBidDetailAdminDto{
    return new self(
        project_id: $projectBidDetail->project_id,
        cost_estimation: $projectBidDetail->cost_estimation,
        notice_published_date: $projectBidDetail->notice_published_date,
        newspaper_name: $projectBidDetail->newspaper_name,
        contract_evaluation_decision_date: $projectBidDetail->contract_evaluation_decision_date,
        intent_notice_publish_date: $projectBidDetail->intent_notice_publish_date,
        contract_newspaper_name: $projectBidDetail->contract_newspaper_name,
        contract_acceptance_decision_date: $projectBidDetail->contract_acceptance_decision_date,
        contract_percentage: $projectBidDetail->contract_percentage,
        contractor_name: $projectBidDetail->contractor_name,
        contractor_address: $projectBidDetail->contractor_address,
        contractor_phone: $projectBidDetail->contractor_phone,
        confession_number: $projectBidDetail->confession_number,
        contract_agreement_date: $projectBidDetail->contract_agreement_date,
        contract_assigned_date: $projectBidDetail->contract_assigned_date,
        bid_bond_amount: $projectBidDetail->bid_bond_amount,
        bid_bond_no: $projectBidDetail->bid_bond_no,
        bid_bond_bank_name: $projectBidDetail->bid_bond_bank_name,
        bid_bond_issue_date: $projectBidDetail->bid_bond_issue_date,
        bid_bond_expiry_date: $projectBidDetail->bid_bond_expiry_date,
        performance_bond_no: $projectBidDetail->performance_bond_no,
        performance_bond_amount: $projectBidDetail->performance_bond_amount,
        performance_bond_bank: $projectBidDetail->performance_bond_bank,
        performance_bond_issue_date: $projectBidDetail->performance_bond_issue_date,
        performance_bond_expiry_date: $projectBidDetail->performance_bond_expiry_date,
        performance_bond_extended_date: $projectBidDetail->performance_bond_extended_date,
        insurance_issue_date: $projectBidDetail->insurance_issue_date,
        insurance_expiry_date: $projectBidDetail->insurance_expiry_date,
        insurance_extended_date: $projectBidDetail->insurance_extended_date,
        bid_no: $projectBidDetail->bid_no
    );
}
}
