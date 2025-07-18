<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Employees\Models\Employee;

class ProjectIncharge extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'pln_project_incharge';

    protected $fillable = [
        'employee_id',
        'remarks',
        'plan_id',
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
            'employee_id' => 'string',
            'remarks' => 'string',
            'plan_id' => 'integer',
            'is_active' => 'boolean',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This ProjectIncharge has been {$eventName}");
    }

    public function employee():HasOne
    {
        return $this->hasOne(Employee::class, 'id', 'employee_id');
    }

}
