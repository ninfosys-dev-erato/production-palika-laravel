<?php

namespace Src\Customers\Models;

use App\Models\User;
use Database\Factories\CustomerKycFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Address\Models\District;
use Src\Address\Models\LocalBody;
use Src\Address\Models\Province;
use Src\Customers\Enums\DocumentTypeEnum;
use Src\Customers\Enums\KycStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;

class CustomerKyc extends Model
{
    use SoftDeletes, HasFactory, LogsActivity;

    protected $table = 'tbl_customer_kyc';
    //    protected $appends = ['documentImage1', 'documentImage2'];

    protected $fillable = [
        'customer_id',
        'nepali_date_of_birth',
        'english_date_of_birth',
        'grandfather_name',
        'father_name',
        'mother_name',
        'spouse_name',
        'permanent_province_id',
        'permanent_district_id',
        'permanent_local_body_id',
        'permanent_ward',
        'permanent_tole',
        'temporary_province_id',
        'temporary_district_id',
        'temporary_local_body_id',
        'temporary_ward',
        'temporary_tole',
        'verified_by',
        'rejected_by',
        'reason_to_reject',
        'status',
        'document_type',
        'document_issued_date_nepali',
        'document_issued_date_english',
        'document_issued_at',
        'document_number',
        'document_image1',
        'document_image2',
        'expiry_date_nepali',
        'expiry_date_english'
    ];

    protected $casts = [
        'customer_id' => 'integer',
        'nepali_date_of_birth' => 'string',
        'english_date_of_birth' => 'string',
        'grandfather_name' => 'string',
        'father_name' => 'string',
        'mother_name' => 'string',
        'spouse_name' => 'string',
        'permanent_province_id' => 'integer',
        'permanent_district_id' => 'integer',
        'permanent_local_body_id' => 'integer',
        'permanent_ward' => 'string',
        'permanent_tole' => 'string',
        'temporary_province_id' => 'integer',
        'temporary_district_id' => 'integer',
        'temporary_local_body_id' => 'integer',
        'temporary_ward' => 'string',
        'temporary_tole' => 'string',
        'verified_by' => 'integer',
        'rejected_by' => 'integer',
        'reason_to_reject' => 'string',
        'status' => KycStatusEnum::class,
        'document_type' => DocumentTypeEnum::class,
        'document_issued_date_nepali' => 'string',
        'document_issued_date_english' => 'string',
        'document_issued_at' => 'integer',
        'document_number' => 'string',
        'document_image1' => 'string',
        'document_image2' => 'string',
        'expiry_date_nepali' => 'string',
        'expiry_date_english' => 'string'
    ];

    protected function documentImage1(): Attribute
    {
        return Attribute::make(
            get: fn($value) => is_null($value) ? " " : $value
        );
    }
    protected function documentImage2(): Attribute
    {
        return Attribute::make(
            get: fn($value) => is_null($value) ? " " : $value
        );
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function citizenshipIssueDistrict(): BelongsTo
    {
        return $this->belongsTo(District::class, 'document_issued_at');
    }

    public function permanentProvince(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'permanent_province_id');
    }

    public function permanentDistrict(): BelongsTo
    {
        return $this->belongsTo(District::class, 'permanent_district_id');
    }

    public function permanentLocalBody(): BelongsTo
    {
        return $this->belongsTo(LocalBody::class, 'permanent_local_body_id');
    }

    public function temporaryProvince(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'temporary_province_id');
    }

    public function temporaryDistrict(): BelongsTo
    {
        return $this->belongsTo(District::class, 'temporary_district_id');
    }

    public function temporaryLocalBody(): BelongsTo
    {
        return $this->belongsTo(LocalBody::class, 'temporary_local_body_id');
    }

    public function rejectedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    protected static function newFactory(): CustomerKycFactory|Factory
    {
        return CustomerKycFactory::new();
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }
}
