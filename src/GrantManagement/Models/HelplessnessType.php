<?php

namespace Src\GrantManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @property string $helplessness_type
 */
class HelplessnessType extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'gms_helplessness_types';

    protected $fillable = [
        'helplessness_type',
        'helplessness_type_en',
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
            'helplessness_type' => 'string',
            'helplessness_type_en' => 'string',
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
            ->logOnlyDirty() // Correctly chained with the "->"
            ->setDescriptionForEvent(fn(string $eventName) => "This HelplessnessType has been {$eventName}");
    }
}
