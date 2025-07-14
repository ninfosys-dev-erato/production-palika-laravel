<?php

namespace Src\TokenTracking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Employees\Models\Branch;

/**
    * @property string $token_id
    * @property string $old_branch
    * @property string $current_branch
    * @property string $old_stage
    * @property string $current_stage
    * @property string $old_status
    * @property string $current_status
    * @property string $old_values
    * @property string $current_values
    * @property string $description
 */

class RegisterTokenLog extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'tok_register_token_logs';

    protected $fillable = [
'token_id',
'old_branch',
'current_branch',
'old_stage',
'current_stage',
'old_status',
'current_status',
'old_values',
'current_values',
'description',
];

    public function casts():array{
      return [
    'token_id' => 'string',
    'old_branch' => 'string',
    'current_branch' => 'string',
    'old_stage' => 'string',
    'current_stage' => 'string',
    'old_status' => 'string',
    'current_status' => 'string',
    'old_values' => 'string',
    'current_values' => 'string',
    'description' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This RegisterToken has been {$eventName}");
    }

    public function oldBranch(){
        return $this->belongsTo(Branch::class, 'old_branch');
    }

    public function currentBranch ()
    {
        return $this->belongsTo(Branch::class, 'current_branch');
    }



}
