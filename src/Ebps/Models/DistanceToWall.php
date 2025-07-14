<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class DistanceToWall extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'ebps_distance_to_walls';

    protected $fillable = [
'map_apply_id',
'direction',
'has_road',
'does_have_wall_door',
'dist_left',
'min_dist_left',
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
    'direction' => 'string',
    'has_road' => 'string',
    'does_have_wall_door' => 'string',
    'dist_left' => 'string',
    'min_dist_left' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This DistanceToWall has been {$eventName}");
        }

}
