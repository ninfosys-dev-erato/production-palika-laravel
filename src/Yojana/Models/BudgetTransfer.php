<?php

namespace Src\Yojana\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $user
 * @property int $from_plan
 * @property int $to_plan
 * @property float|int|null $amount
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class BudgetTransfer extends Model{

    protected $table = 'pln_budget_transfer';

    protected $fillable = [
        'from_plan',
        'to_plan',
        'date',
        'user',
        'amount',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by'
    ];

    public function fromPlan (): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'from_plan');
    }

    public function toPlan (): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'to_plan');
    }

    public function budgetTransferDetails (): HasMany
    {
        return $this->hasMany(BudgetTransferDetails::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user');
    }

}
