<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CostEstimationLog extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_cost_estimation_logs';

    protected $fillable = [
        'cost_estimation_id',
        'status',
        'forwarded_to',
        'remarks',
        'date',
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
            'cost_estimation_id' => 'integer',
            'status' => 'string',
            'forwarded_to' => 'string',
            'remarks' => 'string',
            'date' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This Cost Estimation Log has been {$eventName}");
    }
      public function costEstimation()
    {
        return $this->belongsTo(CostEstimation::class, 'cost_estimation_id', 'id');
    }

}
