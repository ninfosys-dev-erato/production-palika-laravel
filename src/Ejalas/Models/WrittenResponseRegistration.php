<?php

namespace Src\Ejalas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class WrittenResponseRegistration extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jms_written_response_registrations';

    protected $fillable = [
        'response_registration_no',
        'complaint_registration_id',
        'registration_date',
        'fee_amount',
        'fee_receipt_no',
        'fee_paid_date',
        'description',
        'claim_request',
        'submitted_within_deadline',
        'fee_receipt_attached',
        'status',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by',
        'template',
        'registration_indicator'
    ];

    public function casts(): array
    {
        return [
            'response_registration_no' => 'string',
            'complaint_registration_id' => 'string',
            'registration_date' => 'string',
            'fee_amount' => 'string',
            'fee_receipt_no' => 'string',
            'fee_paid_date' => 'string',
            'description' => 'string',
            'claim_request' => 'string',
            'submitted_within_deadline' => 'string',
            'fee_receipt_attached' => 'string',
            'status' => 'string',
            'registration_indicator' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This WrittenResponseRegistration has been {$eventName}");
    }
    public function complaintRegistration()
    {
        return $this->belongsTo(ComplaintRegistration::class, 'complaint_registration_id', 'id');
    }
}
