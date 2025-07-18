<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Address\Models\Province;
use Src\Districts\Models\District;
use Src\LocalBodies\Models\LocalBody;

class HouseOwnerDetail extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'ebps_house_owner_details';

    protected $fillable = [
        'id',
        'owner_name',
        'mobile_no',
        'father_name',
        'grandfather_name',
        'citizenship_no',
        'citizenship_issued_date',
        'citizenship_issued_at',
        'province_id',
        'local_body_id',
        'district_id',
        'ward_no',
        'tole',
        'photo',
        'parent_id',
        'ownership_type',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'reason_of_owner_change',
        'status'
    ];

    protected function casts(): array
    {
        return [
            'id' => 'int',
            'owner_name' => 'string',
            'mobile_no' => 'string',
            'father_name' => 'string',
            'grandfather_name' => 'string',
            'citizenship_no' => 'string',
            'citizenship_issued_date' => 'string',
            'citizenship_issued_at' => 'string',
            'province_id' => 'string',
            'local_body_id' => 'string',
            'district_id' => 'string',
            'reason_of_owner_change' => 'string',
            'ward_no' => 'string',
            'tole' => 'string',
            'photo' => 'string',
            'parent_id' => 'string',
            'status' => 'string',
            'ownership_type' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'created_by' => 'string',
            'updated_by' => 'string',
            'deleted_by' => 'string',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This HighTensionLineDetail has been {$eventName}");
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

    public function parent()
    {
        return $this->belongsTo(HouseOwnerDetail::class, 'parent_id');
    }

}
