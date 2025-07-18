<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class MapApplyStep extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'ebps_map_apply_steps';

    protected $fillable = [
'map_apply_id',
'form_id',
'map_step_id',
'reviewed_by',
'template',
'status',
'reason',
'sent_to_approver_at',
'created_at',
'created_by',
'deleted_at',
'deleted_by',
'updated_at',
'updated_by'
];

    public function casts():array{
      return [
    'map_apply_id' => 'string',
    'form_id' => 'string',
    'map_step_id' => 'string',
    'reviewed_by' => 'string',
    'template' => 'string',
    'status' => 'string',
    'reason' => 'string',
    'sent_to_approver_at' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This MapApplyStep has been {$eventName}");
        }
        public function mapApply(): BelongsTo
    {
        return $this->belongsTo(MapApply::class);
    }

    public function mapApplyStepTemplates()
    {
        return $this->hasMany(MapApplyStepTemplate::class, 'map_apply_step_id');
    }

}
