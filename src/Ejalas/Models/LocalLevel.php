<?php

namespace Src\Ejalas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Address\Models\District;
use Src\Address\Models\LocalBody;
use Src\Address\Models\Province;

class LocalLevel extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jms_local_levels';

    protected $fillable = [
        'title',
        'short_title',
        'type',
        'province_id',
        'district_id',
        'local_body_id',
        'mobile_no',
        'email',
        'website',
        'position',
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
            'title' => 'string',
            'short_title' => 'string',
            'type' => 'string',
            'province_id' => 'string',
            'district_id' => 'string',
            'local_body_id' => 'string',
            'mobile_no' => 'string',
            'email' => 'string',
            'website' => 'string',
            'position' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This LocalLevel has been {$eventName}");
    }
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
    public function localBody()
    {
        return $this->belongsTo(LocalBody::class, 'local_body_id', 'id');
    }
}
