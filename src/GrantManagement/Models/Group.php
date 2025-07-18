<?php
namespace Src\GrantManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Address\Models\District;
use Src\Address\Models\LocalBody;
use Src\Address\Models\Province;
use Src\Wards\Models\Ward;

/**
 * @property string $unique_id
 * @property string $name
 * @property string $registration_date
 * @property string $registered_office
 * @property string $monthly_meeting
 * @property string $vat_pan
 * @property string $province_id
 * @property string $district_id
 * @property string $local_body_id
 * @property string $ward_no
 * @property string $village
 * @property string $tole
 * @property string $user_id
 */
class Group extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'gms_groups';

    protected $fillable = [
        'unique_id',
        'name',
        'registration_date',
        'registered_office',
        'monthly_meeting',
        'vat_pan',
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
        'updated_by'
    ];

    public function casts(): array
    {
        return [
            'unique_id' => 'string',
            'name' => 'string',
            'registration_date' => 'string',
            'registered_office' => 'string',
            'monthly_meeting' => 'string',
            'vat_pan' => 'string',
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
            $id = 'GR-' . mt_rand(100000, 999999);
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

    // Log activity for this model
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This Group has been {$eventName}");
    }

    // Relationship with farmers (if applicable)
    public function farmers()
    {
        return $this->belongsToMany(Farmer::class, 'gms_farmer_group', 'group_id', 'farmer_id')
            ->withTimestamps()
            ->withPivot(['created_by', 'updated_by']);
    }

    public function getGranteeNameAttribute(): string
    {
        return $this->name ?? "";
    }

}
