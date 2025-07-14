<?php

namespace Src\Ejalas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Settlement extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jms_settlements';

    protected $fillable = [
        'complaint_registration_id',
        'discussion_date',
        'settlement_date',
        'present_members',
        'settlement_details',
        'is_settled',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by',
        'template',
        'reconciliation_center_id',
    ];

    public function casts(): array
    {
        return [
            'complaint_registration_id' => 'string',
            'discussion_date' => 'string',
            'settlement_date' => 'string',
            'present_members' => 'string',
            'settlement_details' => 'string',
            'reconciliation_center_id' => 'string',
            'is_settled' => 'boolean',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This Settlement has been {$eventName}");
    }
    public function complaintRegistration()
    {
        return $this->belongsTo(ComplaintRegistration::class, 'complaint_registration_id', 'id');
    }
    public function judicialMember()
    {
        return $this->belongsTo(JudicialMember::class, 'present_members', 'id');
    }
}
