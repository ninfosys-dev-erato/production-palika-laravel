<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

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

class AgreementCost extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'pln_agreement_cost';

    protected $fillable = [
        'id',
        'agreement_id',
        'total_amount',
        'total_vat_amount',
        'total_with_vat',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by'
    ];

    public function casts():array{
      return [
            'agreement_id' => 'integer',
            'total_amount' => 'float',
            'total_vat_amount' => 'float',
            'total_with_vat' => 'float',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This AgreementCost has been {$eventName}");
     }

     public function agreement() : BelongsTo
     {
         return $this->belongsTo(Agreement::class, 'agreement_id', 'id');
     }
     public function agreementCostDetails() : HasMany
     {
         return $this->hasMany(AgreementCostDetail::class, 'agreement_cost_id', 'id');
     }



}
