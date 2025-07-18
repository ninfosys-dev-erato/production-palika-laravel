<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Employees\Models\Employee;

class LogBook extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'pln_log_book';

    protected $fillable = [
'employee_id',
'date',
'visit_time',
'return_time',
'visit_type',
'visit_purpose',
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
    'employee_id' => 'string',
    'date' => 'string',
    'visit_time' => 'string',
    'return_time' => 'string',
    'visit_type' => 'string',
    'visit_purpose' => 'string',
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

        public function getActivitylogOptions(): LogOptions
        {
            return LogOptions::defaults()
                ->logFillable()
                ->logOnlyDirty()
                ->setDescriptionForEvent(fn(string $eventName) => "This LogBook has been {$eventName}");
        }

    public function employee() : BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

}
