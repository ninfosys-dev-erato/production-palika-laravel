<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

 /**
    * @property string $agreement_id
    * @property string $source_type_id
    * @property string $material_name
    * @property string $unit
    * @property string $amount
 */

class AgreementGrant extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'pln_agreement_grants';

    protected $fillable = [
'agreement_id',
'source_type_id',
'material_name',
'unit',
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
    'agreement_id' => 'string',
    'source_type_id' => 'string',
    'material_name' => 'string',
    'unit' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This AgreementGrant has been {$eventName}");
     }

     public function agreement(): BelongsTo
     {
         return $this->belongsTo(Agreement::class);
     }

     public function sourceType() :BelongsTo
    {
        return $this->belongsTo(SourceType::class);
     }

}
