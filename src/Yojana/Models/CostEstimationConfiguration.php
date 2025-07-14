<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CostEstimationConfiguration extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_cost_estimation_configurations';

    protected $fillable = [
        'id',
        'cost_estimation_id',
        'configuration',
        'operation_type',
        'rate',
        'amount',
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

        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This BudgetSource has been {$eventName}");
    }

    public function configuration():BelongsTo
    {
        return $this->belongsTo(Configuration::class,'configuration');
    }
    public function configurationRelation():BelongsTo
    {
        return $this->belongsTo(Configuration::class,'configuration');
    }

}
