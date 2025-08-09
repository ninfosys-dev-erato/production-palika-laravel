<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role;

class MapPassGroupMapStep extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'ebps_map_pass_group_map_step';

    protected $fillable = [
'map_step_id',
'map_pass_group_id',
'type',
'position',
        'submitter_role_id',
        'approver_role_id',
'created_at',
'created_by',
'deleted_at',
'deleted_by',
'updated_at',
'updated_by'
];

    public function casts():array{
      return [
        'map_step_id' => 'int',
        'map_pass_group_id' => 'int',
    'type' => 'string',
        'position' => 'int',
        'submitter_role_id' => 'int',
        'approver_role_id' => 'int',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This MapPassGroupMapStep has been {$eventName}");
        }

    // New role relationships
    public function submitterRole(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'submitter_role_id');
    }

    public function approverRole(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'approver_role_id');
    }

    public function mapStep(): BelongsTo
    {
        return $this->belongsTo(MapStep::class, 'map_step_id');
    }

    public function mapPassGroup(): BelongsTo
    {
        return $this->belongsTo(MapPassGroup::class, 'map_pass_group_id');
    }
}
