<?php

namespace Src\Ejalas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class DisputeArea extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jms_dispute_areas';

    protected $fillable = [
        'title',
        'title_en',
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
            'title_en' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This DisputeArea has been {$eventName}");
    }
    public function complaintRegistration()
    {
        return $this->hasMany(ComplaintRegistration::class);
    }
    public function disputeMatter()
    {
        return $this->hasMany(DisputeMatter::class);
    }
}
