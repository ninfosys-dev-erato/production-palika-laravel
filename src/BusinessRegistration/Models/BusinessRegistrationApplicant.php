<?php

namespace Src\BusinessRegistration\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Src\Address\Models\District;
use Src\Address\Models\LocalBody;
use Src\Address\Models\Province;

class BusinessRegistrationApplicant extends Model
{
    use HasFactory;

    protected $table = "brs_business_registration_applicant";

    protected $fillable = [
        'business_registration_id',
        'applicant_name',
        'gender',
        'father_name',
        'grandfather_name',
        'phone',
        'email',
        'citizenship_number',
        'citizenship_issued_date',
        'citizenship_issued_district',
        'applicant_province',
        'applicant_district',
        'applicant_local_body',
        'applicant_ward',
        'applicant_tole',
        'applicant_street',
        'position',
        'created_by',
        'updated_by',
        'deleted_at',
        'deleted_by',
        'citizenship_front',
        'citizenship_rear',
    ];

    protected $casts = [
        'business_registration_id' => 'integer',
        'applicant_name' => 'string',
        'gender' => 'string',
        'father_name' => 'string',
        'grandfather_name' => 'string',
        'phone' => 'string',
        'email' => 'string',
        'citizenship_number' => 'string',
        'citizenship_issued_date' => 'string',
        'citizenship_issued_district' => 'string',
        'applicant_province' => 'string',
        'applicant_district' => 'string',
        'applicant_local_body' => 'string',
        'applicant_ward' => 'string',
        'applicant_tole' => 'string',
        'applicant_street' => 'string',
        'position' => 'string',
        'created_by' => 'string',
        'updated_by' => 'string',
        'deleted_at' => 'string',
        'deleted_by' => 'string',
        'citizenship_front' => 'string',
        'citizenship_rear' => 'string',
    ];

    public function businessRegistration(): BelongsTo
    {
        return $this->belongsTo(BusinessRegistration::class, 'business_registration_id');
    }

    public function applicantProvince(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'applicant_province', 'id');
    }

    public function applicantDistrict(): BelongsTo
    {
        return $this->belongsTo(District::class, 'applicant_district', 'id');
    }


    public function applicantLocalBody(): BelongsTo
    {
        return $this->belongsTo(LocalBody::class, 'applicant_local_body', 'id');
    }


    public function citizenshipDistrict(): BelongsTo
    {
        return $this->belongsTo(District::class, 'citizenship_issued_district', 'id');
    }
}
