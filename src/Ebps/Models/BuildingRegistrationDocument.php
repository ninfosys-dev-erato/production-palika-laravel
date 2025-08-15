<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class BuildingRegistrationDocument extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'ebps_building_registration_apply_step';

    protected $fillable = [
        'title',
        'map_step_id',
        'map_apply_id',
        'file',
        'status',
        'deleted_at',
        'deleted_by',
    ];

    public function casts():array{
        return [
            'title' => 'string',
            'map_step_id' => 'string',
            'map_apply_id' => 'string',
            'status' => 'string',
            'file' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This Document has been {$eventName}");
    }

}
