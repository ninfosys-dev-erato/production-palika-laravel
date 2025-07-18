<?php

namespace Src\BusinessRegistration\Models;

use App\Models\User;
use App\Traits\HelperDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\BusinessRegistration\Enums\ApplicationStatusEnum;
use Src\FiscalYears\Models\FiscalYear;

class BusinessRenewal extends Model
{
    use HasFactory, LogsActivity, HelperDate;

    protected $table = 'brs_business_renewals';

    protected $fillable = [
        'fiscal_year_id',
        'business_registration_id',
        'renew_date',
        'renew_date_en',
        'date_to_be_maintained',
        'date_to_be_maintained_en',
        'renew_amount',
        'penalty_amount',
        'payment_receipt',
        'payment_receipt_date',
        'payment_receipt_date_en',
        'reg_no',
        'registration_no',
        'application_status',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by',
        'approved_at',
        'approved_by',
        'bill_no',
    ];

    protected $casts =
    [
        'fiscal_year_id' => 'string',
        'business_registration_id' => 'string',
        'renew_date' => 'string',
        'renew_date_en' => 'string',
        'date_to_be_maintained' => 'string',
        'date_to_be_maintained_en' => 'string',
        'renew_amount' => 'integer',
        'penalty_amount' => 'integer',
        'payment_receipt' => 'string',
        'payment_receipt_date' => 'string',
        'payment_receipt_date_en' => 'string',
        'reg_no' => 'string',
        'registration_no' => 'string',
        'application_status' => ApplicationStatusEnum::class,
        'created_at' => 'datetime',
        'created_by' => 'string',
        'updated_at' => 'datetime',
        'updated_by' => 'string',
        'deleted_at' => 'datetime',
        'deleted_by' => 'string',
        'approved_at' => 'datetime',
        'approved_by' => 'string',
        'bill_no' => 'string',
    ];


    public function fiscalYear(): BelongsTo
    {
        return $this->belongsTo(FiscalYear::class, 'fiscal_year_id');
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(BusinessRegistration::class, 'business_registration_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This BusinessRenewal has been {$eventName}");
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    public function getNepaliCreatedAtAttribute()
    {
        return $this->adToBs($this->created_at->format('Y-m-d'));
    }
}
