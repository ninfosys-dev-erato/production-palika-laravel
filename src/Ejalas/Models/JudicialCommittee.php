<?php

namespace Src\Ejalas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class JudicialCommittee extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jms_judicial_committees';

    protected $fillable = [
        'committees_title',
        'short_title',
        'title',
        'subtitle',
        'formation_date',
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
            'committees_title' => 'string',
            'short_title' => 'string',
            'title' => 'string',
            'subtitle' => 'string',
            'formation_date' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This JudicialCommittee has been {$eventName}");
    }
}
