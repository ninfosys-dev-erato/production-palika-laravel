<?php

namespace Src\Ejalas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Employees\Models\Designation;

class JudicialEmployee extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jms_judicial_employees';

    protected $fillable = [
        'name',
        'local_level_id',
        'ward_id',
        'level_id',
        'designation_id',
        'join_date',
        'phone_no',
        'email',
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
            'local_level_id' => 'string',
            'ward_id' => 'string',
            'level_id' => 'string',
            'designation_id' => 'string',
            'join_date' => 'string',
            'phone_no' => 'string',
            'email' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This JudicialEmployee has been {$eventName}");
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }
    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }
    public function meeting()
    {
        return $this->belongsToMany(JudicialMeeting::class, 'jms_meeting_employee');
    }
}
