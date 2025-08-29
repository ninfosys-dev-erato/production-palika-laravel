<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Road extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'ebps_roads';

    protected $fillable = [
        'map_apply_id',
        'direction',
        'width',
        'dist_from_middle',
        'min_dist_from_middle',
        'dist_from_side',
        'min_dist_from_side',
        'dist_from_right',
        'min_dist_from_right',
        'setback',
        'min_setback',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by'
    ];

    public function casts(): array
    {
        return [
            'map_apply_id' => 'string',
            'direction' => 'string',
            'width' => 'string',
            'dist_from_middle' => 'string',
            'min_dist_from_middle' => 'string',
            'dist_from_side' => 'string',
            'min_dist_from_side' => 'string',
            'dist_from_right' => 'string',
            'min_dist_from_right' => 'string',
            'setback' => 'string',
            'min_setback' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This Road has been {$eventName}");
    }
}
