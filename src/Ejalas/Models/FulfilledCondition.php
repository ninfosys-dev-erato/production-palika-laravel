<?php

namespace Src\Ejalas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class FulfilledCondition extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jms_fulfilled_conditions';

    protected $fillable = [
        'complaint_registration_id',
        'fulfilling_party',
        'condition',
        'completion_details',
        'completion_proof',
        'due_date',
        'completion_date',
        'entered_by',
        'entry_date',
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
            'complaint_registration_id' => 'string',
            'fulfilling_party' => 'string',
            'condition' => 'string',
            'completion_details' => 'string',
            'completion_proof' => 'string',
            'due_date' => 'string',
            'completion_date' => 'string',
            'entered_by' => 'string',
            'entry_date' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This FulfilledCondition has been {$eventName}");
    }
    public function complaintRegistration()
    {
        return $this->belongsTo(ComplaintRegistration::class, 'complaint_registration_id', 'id');
    }
    public function party()
    {
        return $this->belongsTo(Party::class, 'fulfilling_party', 'id');
    }
    public function judicialEmployee()
    {
        return $this->belongsTo(JudicialEmployee::class, 'entered_by', 'id');
    }
    public function SettlementDetail()
    {
        return $this->belongsTo(SettlementDetail::class, 'condition', 'id');
    }
}
