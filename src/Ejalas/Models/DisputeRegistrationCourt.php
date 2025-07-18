<?php

namespace Src\Ejalas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class DisputeRegistrationCourt extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jms_dispute_registration_courts';

    protected $fillable = [
        'complaint_registration_id',
        'registrar_id',
        'status',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by',
        'is_details_provided',
        'decision_date',
        'template',
        'registration_indicator'
    ];

    public function casts(): array
    {
        return [
            'complaint_registration_id' => 'string',
            'registrar_id' => 'string',
            'status' => 'string',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
            'is_details_provided' => 'boolean',
            'decision_date' => 'string',
            'template' => 'string',
            'registration_indicator' => 'string',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This DisputeRegistrationCourt has been {$eventName}");
    }
    public function complaintRegistration()
    {
        return $this->belongsTo(ComplaintRegistration::class, 'complaint_registration_id', 'id');
    }
    public function judicialEmployee()
    {
        return $this->belongsTo(JudicialEmployee::class, 'registrar_id', 'id');
    }
}
