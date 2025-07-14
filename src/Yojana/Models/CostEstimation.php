<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CostEstimation extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_cost_estimation';

    protected $fillable = [
        'plan_id',
        'date',
        'total_cost',
        'is_revised',
        'revision_no',
        'revision_date',
        'status',
        'document_upload',
        'rate_analysis_document',
        'cost_estimation_document',
        'initial_photo',
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
            'plan_id' => 'string',
            'date' => 'datetime',
            'total_cost' => 'string',
            'is_revised' => 'boolean',
            'revision_count' => 'integer',
            'revision_date' => 'datetime',
            'status' => 'string',
            'document_upload' => 'string',
            'id' => 'int',
            'rate_analysis_document' => 'string',
            'cost_estimation_document' => 'string',
            'initial_photo' => 'string',
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

    public function activityGroup()
    {
        return $this->belongsTo(ProjectActivityGroup::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function costEstimationDetail()
    {
        return $this->hasMany(CostEstimationDetail::class);
    }
    public function plan() : BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
    public function costDetails() : HasMany
    {
        return $this->hasMany(CostDetails::class);
    }

    public function configDetails() : HasMany
    {
        return $this->hasMany(CostEstimationConfiguration::class);
    }

    public function costEstimationLogs() : HasMany
    {
        return $this->hasMany(CostEstimationLog::class);
    }


}
