<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

 /**
    * @property string $plan_id
    * @property string $party_type
    * @property string $party_id
    * @property string $deposit_type
    * @property string $deposit_number
    * @property string $contract_number
    * @property string $bank
    * @property string $issue_date
    * @property string $validity_period
    * @property string $amount
 */

class Collateral extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'pln_collaterals';

    protected $fillable = [
'plan_id',
'party_type',
'party_id',
'deposit_type',
'deposit_number',
'contract_number',
'bank',
'issue_date',
'validity_period',
'amount',
'created_at',
'created_by',
'deleted_at',
'deleted_by',
'updated_at',
'updated_by'
];

    public function casts():array{
      return [
    'plan_id' => 'string',
    'party_type' => 'string',
    'party_id' => 'string',
    'deposit_type' => 'string',
    'deposit_number' => 'string',
    'contract_number' => 'string',
    'bank' => 'string',
    'issue_date' => 'string',
    'validity_period' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This Collateral has been {$eventName}");
     }

}
