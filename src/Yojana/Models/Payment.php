<?php

namespace Src\Yojana\Models;

use App\Traits\HelperDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Yojana\Enums\Installments;

class Payment extends Model
{
    use HasFactory, LogsActivity, HelperDate;

    protected $table = 'pln_payments';

    protected $fillable = [
        'plan_id',
        'evaluation_id',
        'payment_date',
        'estimated_cost',
        'agreement_cost',
        'total_paid_amount',
        'installment',
        'evaluation_amount',
        'previous_advance',
        'current_advance',
        'previous_deposit',
        'current_deposit',
        'total_tax_deduction',
        'total_deduction',
        'paid_amount',
        'bill_amount',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by'
    ];

    protected $casts = [
            'plan_id' => 'int',
            'evaluation_id' => 'int',
            'payment_date' => 'string',
            'estimated_cost' => 'int',
            'agreement_cost' => 'int',
            'total_paid_amount' => 'int',
            'installment' => Installments::class,
            'evaluation_amount' => 'int',
            'previous_advance' => 'int',
            'current_advance' => 'int',
            'previous_deposit' => 'int',
            'current_deposit' => 'int',
            'total_tax_deduction' => 'int',
            'total_deduction' => 'int',
            'paid_amount' => 'int',
            'bill_amount' => 'int',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
        ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This Payment has been {$eventName}");
    }

    public function evaluation(): BelongsTo
    {
        return $this->belongsTo(Evaluation::class, 'evaluation_id', 'id');
    }

    public function taxDeductions(): HasMany
    {
        return $this->hasMany(PaymentTaxDeduction::class, 'payment_id', 'id');
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }

    public function budgetSourcePaymentLogs(): HasMany
    {
        return $this->hasMany(BudgetSourcePaymentLog::class, 'payment_id', 'id');
    }

    public function getPaymentDateNepaliAttribute()
    {
        // this method returns nepali date for created_at for report purpose
        return $this->adToBs($this->payment_date);
    }
}
