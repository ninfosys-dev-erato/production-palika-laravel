<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class MapPassGroupMapStep extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'ebps_map_pass_group_map_step';

    protected $fillable = [
        'map_step_id',
        'map_pass_group_id',
        'type',
        'position',
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

    public function mapStep(): BelongsTo
    {
        return $this->belongsTo(MapStep::class, 'map_step_id');
    }

    public function mapPassGroup(): BelongsTo
    {
        return $this->belongsTo(MapPassGroup::class, 'map_pass_group_id');
    }

    // Scopes for filtering by type
    public function scopeSubmitters($query)
    {
        return $query->where('type', 'submitter');
    }

    public function scopeApprovers($query)
    {
        return $query->where('type', 'approver');
    }

    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at')->whereNull('deleted_by');
    }
}
