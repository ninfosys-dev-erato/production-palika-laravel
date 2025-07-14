<?php

namespace Src\TokenTracking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TokenLog extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'tok_token_logs';

    protected $fillable = [
'token_id',
'old_status',
'new_status',
'status',
'stage_status',
'old_branch',
'new_branch',
'created_at',
'created_by',
'deleted_at',
'deleted_by',
'updated_at',
'updated_by'
];

    public function casts():array{
      return [
    'token_id' => 'string',
    'old_status' => 'string',
    'new_status' => 'string',
    'status' => 'string',
    'stage_status' => 'string',
    'old_branch' => 'string',
    'new_branch' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This TokenLog has been {$eventName}");
        }

}
