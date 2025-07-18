<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class MapApplyStepApprover extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'ebps_map_apply_step_approvers';

    protected $fillable = [
'map_apply_step_id',
'map_pass_group_id',
'user_id',
'status',
'reason',
'type',
'created_at',
'created_by',
'deleted_at',
'deleted_by',
'updated_at',
'updated_by'
];

    public function casts():array{
      return [
    'map_apply_step_id' => 'string',
    'map_pass_group_id' => 'string',
    'user_id' => 'string',
    'status' => 'string',
    'reason' => 'string',
    'type' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This MapApplyStepApprover has been {$eventName}");
        }

}
