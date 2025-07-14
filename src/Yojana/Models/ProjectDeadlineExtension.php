<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ProjectDeadlineExtension extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'pln_project_deadline_extensions';

    protected $fillable = [
'project_id',
'extended_date',
'en_extended_date',
'submitted_date',
'en_submitted_date',
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
    'extended_date' => 'string',
    'en_extended_date' => 'string',
    'submitted_date' => 'string',
    'en_submitted_date' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This ProjectDeadlineExtension has been {$eventName}");
        }

}
