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
use Src\BusinessRegistration\Models\BusinessRequiredDoc;
use Src\BusinessRegistration\Service\BusinessRegistrationAdminService;
use Src\Customers\Enums\GenderEnum;
use Src\Employees\Models\Branch;
use Src\FileTracking\Models\FileRecord;
use Src\Settings\Models\FiscalYear;
use Src\Wards\Models\Ward;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BusinessRegistration extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = "brs_business_registration_data";

    protected $fillable = [
        'entity_name',
        'fiscal_year',
        'registration_date',
        'registration_type',
        'registration_type_id',

        'business_nature',
        'business_category',
        'kardata_number',
        'kardata_miti',
        'main_service_or_goods',
        'total_capital',
        'business_province',
        'business_district',
        'business_local_body',
        'business_ward',
        'business_tole',
        'business_street',
        'purpose',

        'working_capital',
        'fixed_capital',
        'capital_investment',
        'financial_source',
        'required_electric_power',
        'production_capacity',
        'required_manpower',
        'number_of_shifts',
        'operation_date',
        'others',
        'houseownername',
        'monthly_rent',
        'house_owner_phone',
        'rentagreement',
        'east',
        'west',
        'north',
        'south',
        'landplotnumber',
        'area',



        'amount',
        'application_rejection_reason',
        'bill_no',
        'application_date',
        'application_date_en',
        'registration_date_en',
        'registration_number',
        'certificate_number',

        'created_by',
        'updated_by',
        'deleted_at',
        'deleted_by',

        'data',
        'application_status',
        'total_running_day',
        'is_rented',
        'registration_category',
        'business_status',
        'is_previouslyRegistered',
        'application_letter',
        'certificate_letter',

        'signee_name',
    ];

    protected $casts = [
        'registration_type' => BusinessRegistrationType::class,
        'entity_name' => 'string',
        'fiscal_year' => 'string',
        'registration_date' => 'string',
        'registration_type_id' => 'integer',

        'business_nature' => 'string',
        'business_category' => 'string',
        'kardata_number' => 'string',
        'kardata_miti' => 'string',
        'main_service_or_goods' => 'string',
        'total_capital' => 'integer',
        'business_province' => 'string',
        'business_district' => 'string',
        'business_local_body' => 'string',
        'business_ward' => 'string',
        'business_tole' => 'string',
        'business_street' => 'string',
        'purpose' => 'string',

        'working_capital' => 'string',
        'fixed_capital' => 'string',
        'capital_investment' => 'string',
        'financial_source' => 'string',
        'required_electric_power' => 'string',
        'production_capacity' => 'string',
        'required_manpower' => 'string',
        'number_of_shifts' => 'string',
        'operation_date' => 'string',
        'others' => 'string',
        'houseownername' => 'string',
        'monthly_rent' => 'string',
        'house_owner_phone' => 'string',
        'rentagreement' => 'string',
        'east' => 'string',
        'west' => 'string',
        'north' => 'string',
        'south' => 'string',
        'landplotnumber' => 'string',
        'area' => 'string',
        'amount' => 'string',
        'application_rejection_reason' => 'string',
        'bill_no' => 'string',
        'application_date' => 'string',
        'application_date_en' => 'string',
        'registration_date_en' => 'string',
        'registration_number' => 'string',
        'certificate_number' => 'string',

        'created_by' => 'integer',
        'updated_by' => 'integer',

        'data' => 'json',
        'application_status' => 'string',
        'total_running_day' => 'string',
        'is_rented' => 'string',
        'is_previouslyRegistered' => 'string',
        'registration_category' => 'string',
        'business_status' => BusinessStatusEnum::class,
        'application_letter' => 'string',
        'certificate_letter' => 'string',

        'signee_name' => 'string',
    ];


    public function registrationType(): BelongsTo
    {
        return $this->belongsTo(RegistrationType::class, 'registration_type_id');
    }

    public function fiscalYear(): BelongsTo
    {
        return $this->belongsTo(FiscalYear::class, 'fiscal_year', 'id');
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

    // Business relationships
    public function businessProvince(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'business_province', 'id');
    }

    public function businessDistrict(): BelongsTo
    {
        return $this->belongsTo(District::class, 'business_district', 'id');
    }

    public function businessLocalBody(): BelongsTo
    {
        return $this->belongsTo(LocalBody::class, 'business_local_body', 'id');
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

    public function applicants(): HasMany
    {
        return $this->hasMany(BusinessRegistrationApplicant::class, 'business_registration_id');
    }

    public function requiredBusinessDocs(): HasMany
    {
        return $this->hasMany(BusinessRequiredDoc::class, 'business_registration_id');
    }
    public function renewals(): HasMany
    {
        return $this->hasMany(BusinessRenewal::class, 'business_registration_id');
    }
}
