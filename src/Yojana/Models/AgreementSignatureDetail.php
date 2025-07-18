<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

 /**
    * @property string $agreement_id
    * @property string $signature_party
    * @property string $name
    * @property string $position
    * @property string $address
    * @property string $contact_number
    * @property string $date
 */

class AgreementSignatureDetail extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'pln_agreement_signature_details';

    protected $fillable = [
'agreement_id',
'signature_party',
'name',
'position',
'address',
'contact_number',
'date',
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
    'signature_party' => 'string',
    'name' => 'string',
    'position' => 'string',
    'address' => 'string',
    'contact_number' => 'string',
    'date' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This AgreementSignatureDetail has been {$eventName}");
     }

    public function agreement(): BelongsTo
    {
        return $this->belongsTo(Agreement::class, 'agreement_id', 'id');
    }

}
