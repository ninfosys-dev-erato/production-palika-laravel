<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TargetCompletion extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'pln_target_completion';

    protected $fillable = [
        'plan_id',
        'target_entry_id',
        'completed_physical_goal',
        'completed_financial_goal',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by'
    ];

    public function casts():array{
        return [
            'plan_id' => 'string',
            'target_entry_id' => 'string',
            'completed_physical_goal' => 'string',
            'completed_financial_goal' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This Target Completion has been {$eventName}");
    }

    public function processIndicator(): BelongsTo
    {
        return $this->belongsTo(ProcessIndicator::class, 'progress_indicator_id', 'id');
    }

    public function plan() :BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }

    public function targetEntry() :BelongsTo
    {
        return $this->belongsTo(TargetEntry::class, 'target_entry_id', 'id');
    }

}
