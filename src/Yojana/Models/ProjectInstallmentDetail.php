<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ProjectInstallmentDetail extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'pln_project_installment_details';

    protected $fillable = [
'project_id',
'installment_type',
'date',
'amount',
'construction_material_quantity',
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
    'project_id' => 'string',
    'installment_type' => 'string',
    'date' => 'string',
    'amount' => 'string',
    'construction_material_quantity' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This ProjectInstallmentDetail has been {$eventName}");
        }

}
