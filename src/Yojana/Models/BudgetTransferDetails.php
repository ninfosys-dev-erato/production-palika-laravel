<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetTransferDetails extends Model
{
    protected $table = 'pln_budget_transfer_details';

    protected $fillable = [
        'budget_transfer_id',
        'budget_source_id',
        'amount',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by'
    ];

    public function budgetTransfer(): BelongsTo
    {
        return $this->belongsTo(BudgetTransfer::class, 'budget_transfer_id');
    }

    public function budgetSource(): BelongsTo{
        return $this->belongsTo(PlanBudgetSource::class, 'budget_source_id    ','id');
    }
}
