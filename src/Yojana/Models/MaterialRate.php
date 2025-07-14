<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class MaterialRate extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'pln_material_rates';

    protected $fillable = [
'material_id',
'fiscal_year_id',
'is_vat_included',
'is_vat_needed',
'referance_no',
'royalty',
'created_at',
'created_by',
'deleted_at',
'deleted_by',
'updated_at',
'updated_by'
];

    public function casts():array{
      return [
    'material_id' => 'string',
    'fiscal_year_id' => 'string',
    'is_vat_included' => 'string',
    'is_vat_needed' => 'string',
    'referance_no' => 'string',
    'royalty' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This MaterialRate has been {$eventName}");
        }

}
