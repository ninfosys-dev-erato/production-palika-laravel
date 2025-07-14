<?php

namespace Src\TaskTracking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Employees\Models\Employee;

class EmployeeMarkingScore extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'tsk_employee_marking_scores';

    protected $fillable = [
        'employee_marking_id',
        'criteria_id',
        'score_obtained',
        'score_out_of',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by',
        'employee_id',
        'remarks',
        'anusuchi_id'
    ];

    public function casts(): array
    {
        return [
            'employee_marking_id' => 'string',
            'criteria_id' => 'string',
            'score_obtained' => 'string',
            'score_out_of' => 'string',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
            'employee_id' => 'string',
            'remarks' => 'string',
            'anusuchi_id' => 'string',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This EmployeeMarkingScore has been {$eventName}");
    }
    public function employeeMarking()
    {
        return $this->belongsTo(EmployeeMarking::class, 'employee_marking_id', 'id');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
