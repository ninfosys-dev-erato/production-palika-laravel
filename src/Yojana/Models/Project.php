<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Project extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'pln_projects';

    protected $fillable = [
'registration_no',
'fiscal_year_id',
'project_name',
'plan_area_id',
'project_status',
'project_start_date',
'project_completion_date',
'plan_level_id',
'ward_no',
'allocated_amount',
'project_venue',
'evaluation_amount',
'purpose',
'operated_through',
'progress_spent_amount',
'physical_progress_target',
'physical_progress_completed',
'physical_progress_unit',
'first_quarterly_amount',
'first_quarterly_goal',
'second_quarterly_amount',
'second_quarterly_goal',
'third_quarterly_amount',
'third_quarterly_goal',
'agencies_grants',
'share_amount',
'committee_share_amount',
'labor_amount',
'benefited_organization',
'others_benefited',
'expense_head_id',
'contingency_amount',
'other_taxes',
'is_contracted',
'contract_date',
'created_at',
'created_by',
'deleted_at',
'deleted_by',
'updated_at',
'updated_by'
];

    public function casts():array{
      return [
    'registration_no' => 'string',
    'fiscal_year_id' => 'string',
    'project_name' => 'string',
    'plan_area_id' => 'string',
    'project_status' => 'string',
    'project_start_date' => 'string',
    'project_completion_date' => 'string',
    'plan_level_id' => 'string',
    'ward_no' => 'string',
    'allocated_amount' => 'string',
    'project_venue' => 'string',
    'evaluation_amount' => 'string',
    'purpose' => 'string',
    'operated_through' => 'string',
    'progress_spent_amount' => 'string',
    'physical_progress_target' => 'string',
    'physical_progress_completed' => 'string',
    'physical_progress_unit' => 'string',
    'first_quarterly_amount' => 'string',
    'first_quarterly_goal' => 'string',
    'second_quarterly_amount' => 'string',
    'second_quarterly_goal' => 'string',
    'third_quarterly_amount' => 'string',
    'third_quarterly_goal' => 'string',
    'agencies_grants' => 'string',
    'share_amount' => 'string',
    'committee_share_amount' => 'string',
    'labor_amount' => 'string',
    'benefited_organization' => 'string',
    'others_benefited' => 'string',
    'expense_head_id' => 'string',
    'contingency_amount' => 'string',
    'other_taxes' => 'string',
    'is_contracted' => 'string',
    'contract_date' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This Project has been {$eventName}");
        }

}
