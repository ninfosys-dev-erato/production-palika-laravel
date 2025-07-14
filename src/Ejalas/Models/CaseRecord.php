<?php

namespace Src\Ejalas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CaseRecord extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jms_case_records';

    protected $fillable = [
        'complaint_registration_id',
        'discussion_date',
        'decision_date',
        'decision_authority_id',
        'recording_officer_name',
        'recording_officer_position',
        'remarks',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by',
        'template'
    ];

    public function casts(): array
    {
        return [
            'complaint_registration_id' => 'string',
            'discussion_date' => 'string',
            'decision_date' => 'string',
            'decision_authority_id' => 'string',
            'recording_officer_name' => 'string',
            'recording_officer_position' => 'string',
            'remarks' => 'string',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
            'template' => 'string',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This CaseRecord has been {$eventName}");
    }
    public function complaintRegistration()
    {
        return $this->belongsTo(ComplaintRegistration::class, 'complaint_registration_id', 'id');
    }
    public function judicialMember()
    {
        return $this->belongsTo(JudicialMember::class, 'decision_authority_id', 'id');
    }
    public function judicialEmployee()
    {
        return $this->belongsTo(JudicialEmployee::class, 'recording_officer_name', 'id');
    }
}
