<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Yojana\DTO\AgreementCostAdminDto;

/**
 * @property string $agreement_id
 * @property string $cost_estimation_id
 * @property string $activity
 * @property string $unit
 * @property string $quantity
 * @property string $contractor_rate
 * @property string $amount
 * @property string $vat_amount
 * @property string $remarks
 */

class AgreementCostDetail extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'pln_agreement_cost_details';

    protected $fillable = [
        'agreement_cost_id',
        'cost_estimation_detail_id',
        'activity_id',
        'unit',
        'quantity',
        'estimated_rate',
        'contractor_rate',
        'amount',
        'vat_amount',
        'remarks',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by'
    ];

    public function casts():array{
        return [
            'agreement_cost_id' => 'string',
            'cost_estimation_detail_id' => 'string',
            'activity_id' => 'string',
            'unit' => 'string',
            'quantity' => 'integer',
            'estimated_rate' => 'float',
            'contractor_rate' => 'float',
            'amount' => 'float',
            'vat_amount' => 'float',
            'remarks' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This AgreementCostDetail has been {$eventName}");
    }

    public function agreementCost() :BelongsTo
    {
        return $this->belongsTo(AgreementCost::class, 'agreement_cost_id', 'id');
    }

    public function costEstimationDetail() :HasOne
    {
        return $this->hasOne(CostEstimationDetail::class, 'id', 'cost_estimation_detail_id');
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
    }

}
