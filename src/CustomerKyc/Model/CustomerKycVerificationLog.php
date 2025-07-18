<?php

namespace Src\CustomerKyc\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Customers\Models\Customer;

class CustomerKycVerificationLog extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'tbl_customer_kyc_verification_logs';

    protected $fillable = [
        'customer_id',
        'old_status',
        'new_status',
        'old_details',
        'new_details',
        'old_customer_details',
        'new_customer_details',
        'updated_by',
        'remarks',
    ];

    protected $casts = [
        'customer_id' => 'integer',
        'old_status' => 'string',
        'new_status' => 'string',
        'old_details' => 'string',
        'new_details' => 'string',
        'old_customer_details' => 'string',
        'new_customer_details' => 'string',
        'updated_by' => 'string',
        'remarks' => 'string',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }

}
