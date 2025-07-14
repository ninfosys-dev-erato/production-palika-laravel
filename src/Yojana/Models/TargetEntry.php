<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TargetEntry extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'pln_target_entries';

    protected $fillable = [
        'progress_indicator_id',
        'total_physical_progress',
        'total_financial_progress',
        'last_year_physical_progress',
        'last_year_financial_progress',
        'total_physical_goals',
        'total_financial_goals',
        'first_quarter_physical_progress',
        'first_quarter_financial_progress',
        'second_quarter_physical_progress',
        'second_quarter_financial_progress',
        'third_quarter_physical_progress',
        'third_quarter_financial_progress',
        'plan_id',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by'
        ];

    public function casts():array{
      return [
    'progress_indicator_id' => 'string',
    'total_physical_progress' => 'string',
    'total_financial_progress' => 'string',
    'last_year_physical_progress' => 'string',
    'last_year_financial_progress' => 'string',
    'total_physical_goals' => 'string',
    'total_financial_goals' => 'string',
    'first_quarter_physical_progress' => 'string',
    'first_quarter_financial_progress' => 'string',
    'second_quarter_physical_progress' => 'string',
    'second_quarter_financial_progress' => 'string',
    'third_quarter_physical_progress' => 'string',
    'third_quarter_financial_progress' => 'string',
    'plan_id' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This TargetEntry has been {$eventName}");
        }

    public function processIndicator(): BelongsTo
    {
        return $this->belongsTo(ProcessIndicator::class, 'progress_indicator_id', 'id');
    }

    public function unit()
    {
        return $this->hasOneThrough(
            Unit::class,
            ProcessIndicator::class,
            'id', // Foreign key on ProcessIndicator table
            'id', // Foreign key on Unit table
            'progress_indicator_id', // Local key on TargetEntry table
            'unit_id' // Local key on ProcessIndicator table
        );
    }

    public function plan() :BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }

    public function targetCompletions() :hasMany
    {
        return $this->hasMany(TargetCompletion::class, 'target_entry_id', 'id');
    }

    public function getCompletedPhysicalGoalsAttribute(): int
    {
        return $this->targetCompletions()->sum('completed_physical_goal');
    }

    public function getCompletedFinancialGoalsAttribute(): int
    {
        return $this->targetCompletions()->sum('completed_financial_goal');
    }
    public function getRemainingPhysicalGoalsAttribute(): int
    {
        return $this->total_physical_progress - $this->targetCompletions()->sum('completed_physical_goal');
    }

    public function getRemainingFinancialGoalsAttribute(): int
    {
        return $this->total_physical_progress - $this->targetCompletions()->sum('completed_financial_goal');
    }



}
