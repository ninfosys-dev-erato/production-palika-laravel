<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\ProjectBidDetail;

class ProjectBidDetailsExport implements FromCollection
{
    public $project_bid_details;

    public function __construct($project_bid_details) {
        $this->project_bid_details = $project_bid_details;
    }

    public function collection()
    {
        return ProjectBidDetail::select([
'project_id',
'cost_estimation',
'notice_published_date',
'newspaper_name',
'contract_evaluation_decision_date',
'intent_notice_publish_date',
'contract_newspaper_name',
'contract_acceptance_decision_date',
'contract_percentage',
'contractor_name',
'contractor_address',
'contractor_phone',
'confession_number',
'contract_agreement_date',
'contract_assigned_date',
'bid_bond_amount',
'bid_bond_no',
'bid_bond_bank_name',
'bid_bond_issue_date',
'bid_bond_expiry_date',
'performance_bond_no',
'performance_bond_amount',
'performance_bond_bank',
'performance_bond_issue_date',
'performance_bond_expiry_date',
'performance_bond_extended_date',
'insurance_issue_date',
'insurance_expiry_date',
'insurance_extended_date',
'bid_no'
])
        ->whereIn('id', $this->project_bid_details)->get();
    }
}


