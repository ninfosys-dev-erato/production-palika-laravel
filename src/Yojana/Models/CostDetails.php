<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CostDetails extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_cost_details';

    protected $fillable = [
        'id',
        'cost_estimation_id',
        'cost_source',
        'cost_amount',
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

    public function activityGroup()
    {
        return $this->belongsTo(ProjectActivityGroup::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function costEstimation() :BelongsTo
    {
        return $this->belongsTo(CostEstimation::class);
    }

    public function sourceType() :BelongsTo
    {
        return $this->belongsTo(SourceType::class, 'cost_source');
    }

}
