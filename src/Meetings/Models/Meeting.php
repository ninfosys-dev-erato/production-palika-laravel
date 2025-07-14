<?php

namespace Src\Meetings\Models;

use App\Models\User;
use Database\Factories\MeetingFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\FiscalYears\Models\FiscalYear;
use Src\Meetings\Enums\RecurrenceTypeEnum;
use Src\Yojana\Models\Committee;
use Src\Yojana\Models\CommitteeMember;

class Meeting extends Model
{
    use SoftDeletes, HasFactory, LogsActivity;

    protected $table = 'met_meetings';

    protected $fillable = [
        'fiscal_year_id',
        'committee_id',
        'meeting_id',
        'meeting_name',
        'recurrence',
        'start_date',
        'en_start_date',
        'end_date',
        'en_end_date',
        'recurrence_end_date',
        'en_recurrence_end_date',
        'description',
        'user_id',
        'is_print',
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
            'fiscal_year_id' => 'int',
            'committee_id' => 'int',
            'meeting_id' => 'int',
            'meeting_name' => 'string',
            'recurrence' => RecurrenceTypeEnum::class,
            'start_date' => 'string',
            'end_date' => 'string',
            'recurrence_end_date' => 'string',
            'description' => 'string',
            'user_id' => 'string',
            'is_print' => 'boolean',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
        ];
    }

    public function getRecurrenceLabelAttribute(): string
    {
        return RecurrenceTypeEnum::getLabel(RecurrenceTypeEnum::from($this->recurrence));
    }

    public function fiscalYear(): BelongsTo
    {
        return $this->belongsTo(FiscalYear::class, 'fiscal_year_id');
    }

    public function committee(): BelongsTo
    {
        return $this->belongsTo(Committee::class, 'committee_id', 'id');
    }

    public function committeeMembers():HasMany
    {
        return $this->hasMany(
            CommitteeMember::class,
            'committee_id',
            'committee_id',
        );
    }

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class, 'meeting_id');
    }
    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function minute(): HasOne
    {
        return $this->hasOne(Minute::class);
    }

    public function decisions(): HasMany
    {
        return $this->hasMany(Decision::class);
    }

    public function agendas(): HasMany
    {
        return $this->hasMany(Agenda::class);
    }

    public function invitedMembers(): HasMany
    {
        return $this->hasMany(InvitedMember::class,'meeting_id');
    }

    protected static function newFactory(): MeetingFactory|Factory
    {
        return MeetingFactory::new();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }
}
