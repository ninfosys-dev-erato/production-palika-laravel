<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class StoreyDetail extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'ebps_storey_details';

    protected $fillable = [
'map_apply_id',
'storey_id',
'purposed_area',
'former_area',
'height',
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
    'map_apply_id' => 'string',
    'storey_id' => 'string',
    'purposed_area' => 'string',
    'former_area' => 'string',
    'height' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This StoreyDetail has been {$eventName}");
        }
        public function storey()
        {
            return $this->belongsTo(Storey::class);
        }

}
