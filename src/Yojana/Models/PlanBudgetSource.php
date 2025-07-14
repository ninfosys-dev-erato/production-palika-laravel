<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Src\DigitalBoard\Models\Program;
use Src\Settings\Models\FiscalYear;

class PlanBudgetSource extends Model
{
    use HasFactory;

    protected $table = 'pln_plan_budget_sources';
    protected $appends = ['remaining_amount'];

    protected $fillable = [
        'plan_id',
        'source_id',
        'program',
        'budget_head_id',
        'expense_head_id',
        'fiscal_year_id',
        'amount',
//        'remaining_amount'
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }


    public function sourceType() : BelongsTo
    {
        return $this->belongsTo(BudgetSource::class,'source_id');
    }

    public function budgetHead() : BelongsTo
    {
        return $this->belongsTo(BudgetHead::class);
    }

    public function expenseHead() : BelongsTo
    {
        return $this->belongsTo(ExpenseHead::class);
    }

    public function fiscalYear() : BelongsTo
    {
        return $this->belongsTo(FiscalYear::class, 'fiscal_year_id');
    }

    public function budgetDetail() :BelongsTo
    {
        return $this->belongsTo(BudgetDetail::class,'program');
    }

    public function budgetTransferDetails() :HasMany
    {
        return $this->hasMany(BudgetTransferDetails::class,'budget_source_id','id');
    }

    public function budgetSourcePaymentLogs() : HasMany
    {
        return $this->hasMany(BudgetSourcePaymentLog::class);
    }

    public function drawnAmount()
    {
        return $this->budgetSourcePaymentLogs()->whereNull('deleted_at')->sum('amount');
    }
    public function transferredAmount()
    {
        return $this->budgetTransferDetails()->whereNull('deleted_at')->sum('amount');
    }

    public function getRemainingAmountAttribute()
    {
        return $this->amount - $this->drawnAmount() - $this->transferredAmount();
    }

}
