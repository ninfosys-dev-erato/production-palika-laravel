<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CostEstimationDetail extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_cost_estimation_details';

    protected $fillable = [
        'id',
        'cost_estimation_id',
        'activity_group_id',
        'activity_id',
        'unit',
        'quantity',
        'rate',
        'amount',
        'is_vatable',
        'vat_amount',
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
            'cost_estimation_id' => 'string',
            'activity_group_id' => 'string',
            'activity_id' => 'string',
            'unit' => 'string',
            'quantity' => 'integer',
            'rate' => 'float',
            'amount' => 'float',
            'is_vatable' => 'string',
            'vat_amount' => 'float',
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
    public function planLevel()
    {
        return $this->belongsTo(PlanLevel::class, 'level_id', 'id');
    }
    public function costEstimation()
    {
        return $this->belongsTo(CostEstimation::class, 'cost_estimation_id', 'id');
    }
    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
    }

    public function unitRelation()
    {
        return $this->belongsTo(Unit::class, 'unit', 'id');
    }
}
