<?php

namespace Src\GrantManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Address\Models\District;
use Src\Address\Models\LocalBody;
use Src\Address\Models\Province;
use Src\GrantManagement\Models\CooperativeType;
use Src\Wards\Models\Ward;

/**
 * @property string $unique_id
 * @property string $name
 * @property string $cooperative_type_id
 * @property string $registration_no
 * @property string $registration_date
 * @property string $vat_pan
 * @property string $objective
 * @property string $affiliation_id
 * @property string $province_id
 * @property string $district_id
 * @property string $local_body_id
 * @property string $ward_no
 * @property string $village
 * @property string $tole
 * @property string $user_id
 */

class Cooperative extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'gms_cooperatives';

    protected $fillable = [
        'unique_id',
        'name',
        'cooperative_type_id',
        'registration_no',
        'registration_date',
        'vat_pan',
        'objective',
        'affiliation_id',
        'province_id',
        'district_id',
        'local_body_id',
        'ward_no',
        'village',
        'tole',
        'user_id',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by',
        'farmer_id',
    ];

    public function casts(): array
    {
        return [
            'unique_id' => 'string',
            'name' => 'string',
            'cooperative_type_id' => 'string',
            'registration_no' => 'string',
            'registration_date' => 'string',
            'vat_pan' => 'string',
            'objective' => 'string',
            'affiliation_id' => 'string',
            'province_id' => 'string',
            'district_id' => 'string',
            'local_body_id' => 'string',
            'ward_no' => 'string',
            'village' => 'string',
            'tole' => 'string',
            'user_id' => 'string',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
            'farmer_id',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($group) {
            $group->unique_id = self::generateUniqueGroupId();
        });
    }

    protected static function generateUniqueGroupId()
    {
        do {
            $id = 'CR-' . mt_rand(100000, 999999);
        } while (self::where('unique_id', $id)->exists());

        return $id;
    }


    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_no');
    }


    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function localBody()
    {
        return $this->belongsTo(LocalBody::class, 'local_body_id');
    }

    public function cooperative_type()
    {
        return $this->belongsTo(CooperativeType::class, 'cooperative_type_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This Cooperative has been {$eventName}");
    }

    public function farmers()
    {
        return $this->belongsToMany(Farmer::class, 'gms_cooperative_farmer', 'cooperative_id', 'farmer_id')
            ->withTimestamps()
            ->withPivot(['created_by', 'updated_by']);
    }

    // In app/Models/YourModel.php

    public function getGranteeNameAttribute()
    {
        return $this->name ??"" ;
    }


}
