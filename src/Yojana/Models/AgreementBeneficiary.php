<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

 /**
    * @property string $agreement_id
    * @property string $beneficiary_id
    * @property string $total_count
    * @property string $men_count
    * @property string $women_count
 */

class AgreementBeneficiary extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'pln_agreement_beneficiaries';

    protected $fillable = [
'agreement_id',
'beneficiary_id',
'total_count',
'men_count',
'women_count',
'created_at',
'created_by',
'deleted_at',
'deleted_by',
'updated_at',
'updated_by'
];

    public function casts():array{
      return [
    'agreement_id' => 'string',
    'beneficiary_id' => 'string',
    'total_count' => 'string',
    'men_count' => 'string',
    'women_count' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This AgreementBeneficiary has been {$eventName}");
     }

    public function agreement(): BelongsTo
    {
        return $this->belongsTo(Agreement::class);
    }

    public function beneficiary() :BelongsTo
    {
        return $this->belongsTo(BenefitedMember::class, 'beneficiary_id');
    }

}
