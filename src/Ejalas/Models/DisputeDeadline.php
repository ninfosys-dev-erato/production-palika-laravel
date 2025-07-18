<?php

namespace Src\Ejalas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class DisputeDeadline extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jms_dispute_deadlines';

    protected $fillable = [
        'complaint_registration_id',
        'registrar_id',
        'deadline_set_date',
        'deadline_extension_period',
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
            'registrar_id' => 'string',
            'deadline_set_date' => 'string',
            'deadline_extension_period' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This DisputeDeadline has been {$eventName}");
    }
    public function complaintRegistration()
    {
        return $this->belongsTo(ComplaintRegistration::class, 'complaint_registration_id', 'id');
    }
    public function judicialMember()
    {
        return $this->belongsTo(JudicialMember::class, 'registrar_id', 'id');
    }
}
