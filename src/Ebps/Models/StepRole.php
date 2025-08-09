<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role;

class StepRole extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'ebps_step_roles';

    protected $fillable = [
        'map_step_id',
        'role_id',
        'role_type',
        'position',
        'is_active',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by'
    ];

    public function casts(): array
    {
        return [
            'map_step_id' => 'int',
            'role_id' => 'int',
            'role_type' => 'string',
            'position' => 'int',
            'is_active' => 'boolean',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This StepRole has been {$eventName}");
    }

    public function mapStep(): BelongsTo
    {
        return $this->belongsTo(MapStep::class, 'map_step_id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    // Scopes for filtering by role type
    public function scopeSubmitters($query)
    {
        return $query->where('role_type', 'submitter');
    }

    public function scopeApprovers($query)
    {
        return $query->where('role_type', 'approver');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
} 