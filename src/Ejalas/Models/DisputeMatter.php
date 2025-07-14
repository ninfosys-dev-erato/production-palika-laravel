<?php

namespace Src\Ejalas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class DisputeMatter extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jms_dispute_matters';

    protected $fillable = [
        'title',
        'dispute_area_id',
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
            'dispute_area_id' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This DisputeMatter has been {$eventName}");
    }
    public function disputeArea()
    {
        return $this->belongsTo(DisputeArea::class, 'dispute_area_id', 'id');
    }
    public function complaintRegistration()
    {
        return $this->hasMany(ComplaintRegistration::class);
    }
}
