<?php

namespace Src\Ejalas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ReconciliationCenter extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jms_reconciliation_centers';

    protected $fillable = [
        'reconciliation_center_title',
        'surname',
        'title',
        'subtile',
        'ward_id',
        'established_date',
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
            'reconciliation_center_title' => 'string',
            'surname' => 'string',
            'title' => 'string',
            'subtile' => 'string',
            'ward_id' => 'string',
            'established_date' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This ReconciliationCenter has been {$eventName}");
    }
}
