<?php

namespace Src\Meetings\Models;

use Database\Factories\InvitedMemberFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Src\Meetings\Models\Meeting;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class InvitedMember extends Model
{
    use SoftDeletes, Notifiable, HasFactory, LogsActivity;

    protected $table = 'met_invited_members';

    protected $fillable = [
        'name',
        'meeting_id',
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
            'name' => 'string',
            'meeting_id' => 'string',
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

    protected $appends = [
        'mobile_no'
    ];

    public function mobileNo(): Attribute
    {
        return Attribute::get(fn($value, $attributes) => $attributes['phone'] ?? '');
    }

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class, 'meeting_id');
    }

    protected static function newFactory(): InvitedMemberFactory|Factory
    {
        return InvitedMemberFactory::new();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }

}