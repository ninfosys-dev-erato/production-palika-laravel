<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class BudgetSourcePaymentLog extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_budget_source_payment_logs';

    protected $fillable = [
        'payment_id',
        'plan_budget_source_id',
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
            'payment_id' => 'int',
            'plan_budget_source_id' => 'int',
            'amount' => 'float',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This Budget Source Log has been {$eventName}");
    }

    public function payment() :BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }

    public function budgetSource() : BelongsTo
    {
        return $this->belongsTo(PlanBudgetSource::class,'plan_budget_source_id','id');
    }

}
