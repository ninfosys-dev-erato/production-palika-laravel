<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class BudgetSource extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_budget_sources';

    protected $fillable = [
        'title',
        'code',
        'level_id',
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
            'level_id' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This BudgetSource has been {$eventName}");
    }

    public function implementationLevel() : BelongsTo
    {
        return $this->belongsTo(ImplementationLevel::class, 'level_id', 'id');
    }

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'pln_plan_budget_sources', 'source_id', 'plan_id');
    }

}
