<?php

namespace Src\GrantManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Address\Models\District;
use Src\Address\Models\LocalBody;
use Src\Address\Models\Province;
use Src\Customers\Models\Customer;
use Src\Wards\Models\Ward;

/**
 * @property string $unique_id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $photo
 * @property string $gender
 * @property string $marital_status
 * @property string $spouse_name
 * @property string $father_name
 * @property string $grandfather_name
 * @property string $citizenship_no
 * @property string $farmer_id_card_no
 * @property string $national_id_card_no
 * @property string $phone_no
 * @property string $province_id
 * @property string $district_id
 * @property string $local_body_id
 * @property string $ward_no
 * @property string $village
 * @property string $tole
 * @property string $user_id
 */

class Farmer extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'gms_farmers';

    protected $fillable = [
        'unique_id',
        'first_name',
        'middle_name',
        'last_name',
        'photo',
        'gender',
        'marital_status',
        'spouse_name',
        'father_name',
        'grandfather_name',
        'citizenship_no',
        'farmer_id_card_no',
        'national_id_card_no',
        'phone_no',
        'province_id',
        'district_id',
        'local_body_id',
        'ward_no',
        'village',
        'tole',
        'user_id',
        'involved_farmers_ids',
        'farmer_ids',
        'relationships',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by'
    ];

    public function casts(): array
    {
        return [
            'unique_id' => 'string',
            'first_name' => 'string',
            'middle_name' => 'string',
            'last_name' => 'string',
            'photo' => 'string',
            'gender' => 'string',
            'marital_status' => 'string',
            'spouse_name' => 'string',
            'father_name' => 'string',
            'grandfather_name' => 'string',
            'citizenship_no' => 'string',
            'farmer_id_card_no' => 'string',
            'national_id_card_no' => 'string',
            'phone_no' => 'string',
            'province_id' => 'string',
            'district_id' => 'string',
            'local_body_id' => 'string',
            'ward_no' => 'string',
            'village' => 'string',
            'tole' => 'string',
            'user_id' => 'string',
            'involved_farmers_ids' => 'array',
            'id' => 'int',
            'farmer_ids' => 'array',
            'relationships' => 'array',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',

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
            $id = 'FM-' . mt_rand(100000, 999999);
        } while (self::where('unique_id', $id)->exists());

        return $id;
    }

    public function user()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_no');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function localBody()
    {
        return $this->belongsTo(LocalBody::class, 'local_body_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This Farmer has been {$eventName}");
    }

    public function involvedFarmers()
    {
        return $this->belongsToMany(Farmer::class, 'involved_farmers', 'farmer_id', 'involved_farmer_id');
    }


    public function groups()
    {
        return $this->belongsToMany(Group::class, 'gms_farmer_group', 'farmer_id', 'group_id')
            ->withTimestamps()
            ->withPivot(['created_by', 'updated_by']);
    }

    public function cooperatives()
    {
        return $this->belongsToMany(Cooperative::class, 'gms_cooperative_farmer', 'farmer_id', 'cooperative_id')
            ->withTimestamps()
            ->withPivot(['created_by', 'updated_by']);
    }

    public function enterprises()
    {
        return $this->belongsToMany(Enterprise::class, 'gms_enterprise_farmer', 'farmer_id', 'enterprise_id')
            ->withTimestamps()
            ->withPivot(['created_by', 'updated_by']);
    }

    public function getGranteeNameAttribute(): string
    {
        // return collect([
        //     $this->first_name,
        //     $this->middle_name,
        //     $this->last_name,
        // ])->filter()->join(' ');
        return  optional($this->user)->name;
    }
}
