<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ProjectGroup extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_project_groups';

    protected $fillable = [
        'title',
        'group_id',
        'area_id',
        'code',
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
            'title' => 'string',
            'group_id' => 'string',
            'area_id' => 'string',
            'code' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This ProjectGroup has been {$eventName}");
    }
    public function planArea()
    {
        return $this->belongsTo(PlanArea::class, 'area_id', 'id');
    }

    public function sameGroup()
    {
        return $this->belongsTo(ProjectGroup::class, 'group_id', 'id');
    }

    public function plans() : HasMany
    {
        return $this->hasMany(Plan::class, 'group_id', 'id');
    }
}
