<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class BuildingCriteria extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'ebps_building_criterias';

    protected $fillable = [
'min_gcr',
'min_far',
'min_dist_center',
'min_dist_side',
'min_dist_right',
'setback',
'dist_between_wall_and_boundaries',
'public_place_distance',
'cantilever_distance',
'high_tension_distance',
'is_active',
'created_at',
'created_by',
'deleted_at',
'deleted_by',
'updated_at',
'updated_by'
];

    public function casts():array{
      return [
    'min_gcr' => 'string',
    'min_far' => 'string',
    'min_dist_center' => 'string',
    'min_dist_side' => 'string',
    'min_dist_right' => 'string',
    'setback' => 'string',
    'dist_between_wall_and_boundaries' => 'string',
    'public_place_distance' => 'string',
    'cantilever_distance' => 'string',
    'high_tension_distance' => 'string',
    'is_active' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This BuildingCriteria has been {$eventName}");
        }

}
