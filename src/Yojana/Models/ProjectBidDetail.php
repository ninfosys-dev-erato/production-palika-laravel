<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ProjectBidDetail extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'pln_project_bid_details';

    protected $fillable = [
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
'bid_no',
'created_at',
'created_by',
'deleted_at',
'deleted_by',
'updated_at',
'updated_by'
];

    public function casts():array{
      return [
    'project_id' => 'string',
    'cost_estimation' => 'string',
    'notice_published_date' => 'string',
    'newspaper_name' => 'string',
    'contract_evaluation_decision_date' => 'string',
    'intent_notice_publish_date' => 'string',
    'contract_newspaper_name' => 'string',
    'contract_acceptance_decision_date' => 'string',
    'contract_percentage' => 'string',
    'contractor_name' => 'string',
    'contractor_address' => 'string',
    'contractor_phone' => 'string',
    'confession_number' => 'string',
    'contract_agreement_date' => 'string',
    'contract_assigned_date' => 'string',
    'bid_bond_amount' => 'string',
    'bid_bond_no' => 'string',
    'bid_bond_bank_name' => 'string',
    'bid_bond_issue_date' => 'string',
    'bid_bond_expiry_date' => 'string',
    'performance_bond_no' => 'string',
    'performance_bond_amount' => 'string',
    'performance_bond_bank' => 'string',
    'performance_bond_issue_date' => 'string',
    'performance_bond_expiry_date' => 'string',
    'performance_bond_extended_date' => 'string',
    'insurance_issue_date' => 'string',
    'insurance_expiry_date' => 'string',
    'insurance_extended_date' => 'string',
    'bid_no' => 'string',
    'id' => 'int',
    'created_at' => 'datetime',
    'created_by' => 'string',
    'updated_at' => 'datetime',
    'updated_by' => 'string',
    'deleted_at' => 'datetime',
    'deleted_by' => 'string',
];
    }

        public function getActivitylogOptions(): LogOptions
        {
            return LogOptions::defaults()
                ->logFillable()
                ->logOnlyDirty()
                ->setDescriptionForEvent(fn(string $eventName) => "This ProjectBidDetail has been {$eventName}");
        }

}
