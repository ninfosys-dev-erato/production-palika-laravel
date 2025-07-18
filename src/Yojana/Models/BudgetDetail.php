<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class BudgetDetail extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'pln_budget_details';

    protected $fillable = [
        'ward_id',
        'amount',
        'program',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by'
        ];

    public function casts():array{
        return [
            'ward_id' => 'string',
            'amount' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This BudgetDetail has been {$eventName}");
        }

    public function drawnAmount()
    {
        return $this->hasMany(PlanBudgetSource::class,'program')->sum('amount');
    }

    public function getRemainingAmountAttribute()
    {
        return $this->amount - $this->drawnAmount();
    }

    public function planBudgetSources() : HasMany
    {
        return $this->hasMany(PlanBudgetSource::class, 'program');
    }

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'pln_plan_budget_sources', 'program', 'plan_id');
    }

}
