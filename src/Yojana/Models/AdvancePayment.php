<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Yojana\Enums\Installments;

class AdvancePayment extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_advance_payments';

    protected $fillable = [
        'plan_id',
        'installment',
        'date',
        'clearance_date',
        'advance_deposit_number',
        'paid_amount',
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
            'installment' => Installments::class,
            'date' => 'string',
            'clearance_date' => 'string',
            'advance_deposit_number' => 'string',
            'paid_amount' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This AdvancePayment has been {$eventName}");
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }
}
