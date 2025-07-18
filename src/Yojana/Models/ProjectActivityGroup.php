<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ProjectActivityGroup extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_project_activity_groups';

    protected $fillable = [
        'title',
        'code',
        'group_id',
        'norms_type',
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
            'code' => 'string',
            'group_id' => 'string',
            'norms_type' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This ProjectActivityGroup has been {$eventName}");
    }
    public function sameProjectActivityGroup()
    {
        return $this->belongsTo(ProjectActivityGroup::class, 'group_id', 'id');
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }
    public function normType()
    {
        return $this->belongsTo(NormType::class, 'norms_type', 'id');
    }
}
