<?php

namespace Src\TaskTracking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Anusuchi extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'tsk_anusuchis';

    protected $fillable = [
'name',
'name_en',
'date',
'description',
'created_at',
'created_by',
'deleted_at',
'deleted_by',
'updated_at',
'updated_by'
];

    public function casts():array{
      return [
    'name' => 'string',
    'name_en' => 'string',
    'description' => 'string',
    'id' => 'int',
    'created_at' => 'datetime',
    'created_by' => 'string',
    'updated_at' => 'datetime',
    'updated_by' => 'string',
    'deleted_at' => 'datetime',
    'deleted_by' => 'string',
];
    }

    public function criterion():HasMany{
        return $this->hasMany(Criterion::class);
    }
    public function getActivitylogOptions(): LogOptions
        {
            return LogOptions::defaults()
                ->logFillable()
                ->logOnlyDirty()
                ->setDescriptionForEvent(fn(string $eventName) => "This Anusuchi has been {$eventName}");
        }


}
