<?php

namespace Src\Ejalas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\FiscalYears\Models\FiscalYear;

class JudicialMeeting extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jms_judicial_meetings';

    protected $fillable = [
        'fiscal_year_id',
        'meeting_date',
        'meeting_time',
        'meeting_number',
        'decision_number',
        'invited_employee_id',
        'members_present_id',
        'meeting_topic',
        'decision_details',
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
            'fiscal_year_id' => 'string',
            'meeting_date' => 'string',
            'meeting_time' => 'string',
            'meeting_number' => 'string',
            'decision_number' => 'string',
            'invited_employee_id' => 'array',
            'members_present_id' => 'array',
            'meeting_topic' => 'string',
            'decision_details' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This JudicialMeeting has been {$eventName}");
    }
    public function members()
    {
        return $this->belongsToMany(JudicialMember::class, 'jms_meeting_member');
    }
    public function fiscalYear()
    {
        return $this->belongsTo(FiscalYear::class, 'fiscal_year_id', 'id');
    }
    public function employees()
    {
        return $this->belongsToMany(JudicialEmployee::class, 'jms_meeting_employee');
    }
}
