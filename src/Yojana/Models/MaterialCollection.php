<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class MaterialCollection extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'pln_material_collections';

    protected $fillable = [
'material_rate_id',
'unit_id',
'activity_no',
'remarks',
'fiscal_year_id',
'created_at',
'created_by',
'deleted_at',
'deleted_by',
'updated_at',
'updated_by'
];

    public function casts():array{
      return [
    'material_rate_id' => 'string',
    'unit_id' => 'string',
    'activity_no' => 'string',
    'remarks' => 'string',
    'fiscal_year_id' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This MaterialCollection has been {$eventName}");
        }

}
