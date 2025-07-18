<?php

namespace Src\TaskTracking\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Employees\Models\Employee;

class EmployeeMarking extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'tsk_employee_markings';

    protected $fillable = [
        'employee_id',
        'anusuchi_id',
        'criteria_id',
        'score',
        'fiscal_year',
        'period_title',
        'period_type',
        'date_from',
        'date_to',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by',
        'full_score',
        'obtained_score',
        'month',

    ];

    public function casts(): array
    {
        return [
            'employee_id' => 'string',
            'anusuchi_id' => 'string',
            'score' => 'string',
            'criteria_id' => 'string',
            'fiscal_year' => 'string',
            'period_title' => 'string',
            'period_type' => 'string',
            'date_from' => 'string',
            'date_to' => 'string',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
            'marking_batch_id' => 'string',
            'full_score' => 'string',
            'obtained_score' => 'string',
            'month' => 'string'
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This EmployeeMarking has been {$eventName}");
    }
    public function employeeMarkingScore()
    {
        return $this->hasMany(EmployeeMarkingScore::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
    public function anusuchi()
    {
        return $this->belongsTo(Anusuchi::class, 'anusuchi_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }
}
