<?php

namespace Src\TaskTracking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Criterion extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'tsk_criteria';

    protected $fillable = [
'anusuchi_id',
'name',
'name_en',
'max_score',
'min_score',
'created_at',
'created_by',
'deleted_at',
'deleted_by',
'updated_at',
'updated_by'
];

    public function casts():array{
      return [
    'anusuchi_id' => 'integer',
    'name' => 'string',
    'name_en' => 'string',
    'max_score' => 'string',
    'min_score' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This Criterion has been {$eventName}");
        }

}
