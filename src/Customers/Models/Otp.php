<?php

namespace Src\Customers\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Customers\Models\Customer;

class Otp extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'tbl_customer_otps';
    protected $fillable = ['mobile_no', 'otp', 'customer_id', 'purpose', 'verification_flag'];

    public function customer()
    {
        $this->belongsTo(Customer::class);
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }
}
