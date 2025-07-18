<?php

namespace Src\Ejalas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class WitnessesRepresentative extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jms_witnesses_representatives';

    protected $fillable = [
        'complaint_registration_id',
        'name',
        'address',
        'is_first_party',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by',
        'template'
    ];

    public function casts(): array
    {
        return [
            'complaint_registration_id' => 'string',
            'name' => 'string',
            'address' => 'string',
            'is_first_party' => 'boolean',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
            'template' => 'string'
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This WitnessesRepresentative has been {$eventName}");
    }
    public function complaintRegistration()
    {
        return $this->belongsTo(ComplaintRegistration::class, 'complaint_registration_id', 'id'); //only defined here
    }
}
