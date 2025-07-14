<?php

namespace Src\TokenTracking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TokenStageStatus extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'tok_token_stage_status';

    protected $fillable = [
'token_id',
'branch',
'stage',
'status',
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
    'branch' => 'string',
'stage'=> 'string',
'status' =>'string',
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


        public function token(): BelongsTo
        {
            return $this->belongsTo(RegisterToken::class, 'current_branch');
        }
    

}
