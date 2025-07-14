<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class FormMapStep extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'ebps_form_map_step';

    protected $fillable = [
'form_id',
'map_step_id',
'can_be_null',
'created_at',
'created_by',
'deleted_at',
'deleted_by',
'updated_at',
'updated_by'
];

    public function casts():array{
      return [
    'form_id' => 'string',
    'map_step_id' => 'string',
    'can_be_null' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This FormMapStep has been {$eventName}");
        }

        public function step()
        {
            return $this->belongsTo(MapStep::class, 'map_step_id', 'id');
        }

}
