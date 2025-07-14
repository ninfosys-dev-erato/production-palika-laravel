<?php

namespace Src\Ejalas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Address\Models\District;
use Src\Address\Models\LocalBody;
use Src\Address\Models\Province;


class Party extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jms_parties';

    protected $fillable = [
        'name',
        'age',
        'phone_no',
        'citizenship_no',
        'gender',
        'grandfather_name',
        'father_name',
        'spouse_name',
        'permanent_province_id',
        'permanent_district_id',
        'permanent_local_body_id',
        'permanent_ward_id',
        'permanent_tole',
        'temporary_province_id',
        'temporary_district_id',
        'temporary_local_body_id',
        'temporary_ward_id',
        'temporary_tole',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by',
    ];

    public function casts(): array
    {
        return [
            'name' => 'string',
            'age' => 'string',
            'phone_no' => 'string',
            'citizenship_no' => 'string',
            'gender' => 'string',
            'grandfather_name' => 'string',
            'father_name' => 'string',
            'spouse_name' => 'string',
            'permanent_province_id' => 'string',
            'permanent_district_id' => 'string',
            'permanent_local_body_id' => 'string',
            'permanent_ward_id' => 'string',
            'permanent_tole' => 'string',
            'temporary_province_id' => 'string',
            'temporary_district_id' => 'string',
            'temporary_local_body_id' => 'string',
            'temporary_ward_id' => 'string',
            'temporary_tole' => 'string',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This Party has been {$eventName}");
    }

    public function permanentProvince()
    {
        return $this->belongsTo(Province::class, 'permanent_province_id', 'id');
    }

    public function permanentDistrict()
    {
        return $this->belongsTo(District::class, 'permanent_district_id', 'id');
    }

    public function permanentLocalBody()
    {
        return $this->belongsTo(LocalBody::class, 'permanent_local_body_id', 'id');
    }

    public function temporaryProvince()
    {
        return $this->belongsTo(Province::class, 'temporary_province_id', 'id');
    }

    public function temporaryDistrict()
    {
        return $this->belongsTo(District::class, 'temporary_district_id', 'id');
    }

    public function temporaryLocalBody()
    {
        return $this->belongsTo(LocalBody::class, 'temporary_local_body_id', 'id');
    }
    public function complaintRegistration()
    {
        return $this->belongsToMany(ComplaintRegistration::class, 'complaint_party', 'party_id', 'complaint_id')
            ->withPivot('type')
            ->withTimestamps();
    }
}
