<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Activity extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_activities';

    protected $fillable = [
        'title',
        'group_id',
        'code',
        'ref_code',
        'unit_id',
        'qty_for',
        'will_be_in_use',
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
            'group_id' => 'string',
            'code' => 'string',
            'ref_code' => 'string',
            'unit_id' => 'string',
            'qty_for' => 'string',
            'will_be_in_use' => 'boolean',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This Activity has been {$eventName}");
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
    public function projectActivityGroup()
    {
        return $this->belongsTo(ProjectActivityGroup::class, 'group_id', 'id');
    }
}
