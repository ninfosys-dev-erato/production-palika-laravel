<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Yojana\Models\PlanArea;

class SubRegion extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_sub_regions';

    protected $fillable = [
        'name',
        'code',
        'area_id',
        'in_use',
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
            'name' => 'string',
            'code' => 'string',
            'area_id' => 'string',
            'in_use' => 'boolean',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This SubRegion has been {$eventName}");
    }
    public function planArea()
    {
        return $this->belongsTo(PlanArea::class, 'area_id', 'id');
    }

    public function plans()
    {
        return $this->hasMany(Plan::class, 'sub_region_id', 'id');
    }

}
