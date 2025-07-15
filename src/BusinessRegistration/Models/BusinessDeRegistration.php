<?php

namespace Src\BusinessRegistration\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Src\BusinessRegistration\Enums\ApplicationStatusEnum;

class BusinessDeregistration extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'brs_business_deregistration_data';

    protected $fillable = [
        'brs_registration_data_id',
        'fiscal_year',
        'application_date',
        'application_date_en',
        'amount',
        'application_rejection_reason',
        'bill_no',
        'registration_number',
        'data',
        'application_status',
        'bill',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_at',
        'deleted_by',
        'registration_type_id',
    ];

    protected $casts = [
        'brs_registration_data_id' => 'integer',
        'fiscal_year' => 'string',
        'application_date' => 'string',
        'application_date_en' => 'string',
        'amount' => 'string',
        'application_rejection_reason' => 'string',
        'bill_no' => 'string',
        'registration_number' => 'string',
        'data' => 'json',
        'application_status' => ApplicationStatusEnum::class,
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_at' => 'datetime',
        'deleted_by' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'registration_type_id' => 'integer',
        'bill' => 'string',

    ];

    public function businessRegistration()
    {
        return $this->belongsTo(BusinessRegistration::class, 'brs_registration_data_id', 'id');
    }
}
