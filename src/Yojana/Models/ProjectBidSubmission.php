<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ProjectBidSubmission extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'pln_project_bid_submissions';

    protected $fillable = [
'project_id',
'submission_type',
'submission_no',
'date',
'amount',
'fiscal_year_id',
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
    'submission_type' => 'string',
    'submission_no' => 'string',
    'date' => 'string',
    'amount' => 'string',
    'fiscal_year_id' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This ProjectBidSubmission has been {$eventName}");
        }

}
