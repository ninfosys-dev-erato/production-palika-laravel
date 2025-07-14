<?php

namespace Src\Meetings\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Yojana\Models\CommitteeMember;

class Participant extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'met_participants';

    protected $fillable = [
        'meeting_id',
        'committee_member_id',
        'name',
        'designation',
        'phone',
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
            'meeting_id' => 'string',
            'committee_member_id' => 'string',
            'name' => 'string',
            'designation' => 'string',
            'phone' => 'string',
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

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class, 'meeting_id');
    }

    public function committeeMember(): BelongsTo
    {
        return $this->belongsTo(CommitteeMember::class, 'committee_member_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }

}
