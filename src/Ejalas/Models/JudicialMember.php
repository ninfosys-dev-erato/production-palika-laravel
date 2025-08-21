<?php

namespace Src\Ejalas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Ejalas\Enum\ElectedPosition;
use Src\Ejalas\Enum\JudicialMemberPosition;

class JudicialMember extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jms_judicial_members';

    protected $fillable = [
        'title',
        'member_position',
        'elected_position',
        'status',
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
            'member_position' => JudicialMemberPosition::class,
            'elected_position' => ElectedPosition::class,
            'status' => 'boolean',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This JudicialMember has been {$eventName}");
    }
    public function meetings()
    {
        return $this->belongsToMany(JudicialMeeting::class, 'jms_meeting_member')
            ->withPivot('type')
            ->withTimestamps();
    }
}
