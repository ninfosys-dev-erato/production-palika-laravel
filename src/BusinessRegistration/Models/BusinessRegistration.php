<?php

namespace Src\BusinessRegistration\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Address\Models\District;
use Src\Address\Models\LocalBody;
use Src\Address\Models\Province;
use Src\BusinessRegistration\Enums\ApplicationStatusEnum;
use Src\BusinessRegistration\Enums\BusinessRegistrationType;
use Src\BusinessRegistration\Enums\BusinessStatusEnum;
use Src\BusinessRegistration\Service\BusinessRegistrationAdminService;
use Src\Employees\Models\Branch;
use Src\FileTracking\Models\FileRecord;
use Src\Settings\Models\FiscalYear;
use Src\Wards\Models\Ward;

class BusinessRegistration extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = "brs_business_registration";

    protected $fillable = [
        'registration_type_id',
        'entity_name',
        'amount',
        'bill_no',
        'application_date',
        'application_date_en',
        'registration_date',
        'registration_date_en',
        'registration_number',
        'certificate_number',
        'province_id',
        'district_id',
        'local_body_id',
        'business_nature',
        'department_id',
        'ward_no',
        'way',
        'tole',
        'data',
        'business_status',
        'application_rejection_reason',
        'application_status',
        'bill',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
        'fiscal_year_id',
        'approved_at',
        'approved_by',
        'mobile_no',
        'rejected_at',
        'rejected_by',
        'operator_id', //संचालक
        'preparer_id', //तयार गर्ने
        'approver_id', //प्रमाणित गर्ने
        'applicant_name',
        'applicant_number',
        'registration_id',
        'registration_type',
    ];

    protected $casts = [
        'registration_type_id' => 'string',
        'entity_name' => 'string',
        'applicant_name' => 'string',
        'applicant_number' => 'string',
        'amount' => 'string',
        'bill_no' => 'string',
        'department_id' => 'string',
        'business_nature' => 'string',
        'application_date' => 'string',
        'application_date_en' => 'string',
        'registration_date' => 'string',
        'registration_date_en' => 'string',
        'registration_number' => 'string',
        'certificate_number' => 'string',
        'province_id' => 'string',
        'district_id' => 'string',
        'local_body_id' => 'string',
        'business_status' => 'string',
        'application_rejection_reason' => 'string',
        'application_status' => 'string',
        'ward_no' => 'string',
        'way' => 'string',
        'tole' => 'string',
        'data' => 'json',
        'bill' => 'string',
        'fiscal_year_id' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'created_by' => 'string',
        'updated_by' => 'string',
        'deleted_by' => 'string',
        'approved_at' => 'datetime',
        'approved_by' => 'string',
        'mobile_no' => 'string',
        'rejected_at' => 'datetime',
        'rejected_by' => 'string',
        'operator_id' => 'string', //संचालक
        'preparer_id' => 'string', //तयार गर्ने
        'approver_id' => 'string', //प्रमाणित गर्ने
        'registration_id' => 'string',
        'registration_type' => BusinessRegistrationType::class,
    ];

    public function registrationType(): BelongsTo
    {
        return $this->belongsTo(RegistrationType::class, 'registration_type_id');
    }

    public function fiscalYear(): BelongsTo
    {
        return $this->belongsTo(FiscalYear::class, 'fiscal_year_id');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function localBody(): BelongsTo
    {
        return $this->belongsTo(LocalBody::class, 'local_body_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This business registration has been {$eventName}");
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    public function preparer()
    {
        return $this->belongsTo(User::class, 'preparer_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public function records(): MorphMany
    {
        return $this->morphMany(FileRecord::class, 'subject');
    }
    public function getDocumentAttribute()
    {
        return [(new BusinessRegistrationAdminService())->getLetter($this, 'api')];
    }

    public function department()
    {
        return $this->belongsTo(Branch::class, 'department_id');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }
    public function businessNature()
    {
        return $this->belongsTo(NatureOfBusiness::class, 'business_nature', 'id');
    }
    public function getApplicationStatusNepaliAttribute(): string
    {
        $enum = ApplicationStatusEnum::tryFrom($this->application_status);
        return $enum ? ApplicationStatusEnum::getNepaliLabel($enum) : $this->application_status;
    }
    public function getBusinessStatusNepaliAttribute(): string
    {
        $enum = BusinessStatusEnum::tryFrom($this->business_status);
        return $enum ? BusinessStatusEnum::getNepaliLabel($enum) : '';
    }
    public function parent(): BelongsTo
    {
        return $this->belongsTo(BusinessRegistration::class, 'registration_id');
    }
}
