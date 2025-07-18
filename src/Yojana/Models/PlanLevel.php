<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PlanLevel extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_plan_levels';

    protected $fillable = [
        'plan_level_id',
        'level_name',
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
            'plan_level_id' => 'string',
            'level_name' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This PlanLevel has been {$eventName}");
    }
    public function budgetSource()
    {
        return $this->hasMany(BudgetSource::class);
    }
}
