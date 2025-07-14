<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Yojana\Enums\ConsumerCommitteeMemberDesgination;

class ConsumerCommitteeMember extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_consumer_committee_members';

    protected $fillable = [
        'consumer_committee_id',
        'citizenship_number',
        'name',
        'gender',
        'father_name',
        'husband_name',
        'grandfather_name',
        'father_in_law_name',
        'is_monitoring_committee',
        'designation',
        'address',
        'mobile_number',
        'is_account_holder',
        'citizenship_upload',
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
            'consumer_committee_id' => 'integer',
            'citizenship_number' => 'string',
            'name' => 'string',
            'gender' => 'string',
            'father_name' => 'string',
            'husband_name' => 'string',
            'grandfather_name' => 'string',
            'father_in_law_name' => 'string',
            'is_monitoring_committee' => 'boolean',
            'designation' => ConsumerCommitteeMemberDesgination::class,
            'address' => 'string',
            'is_account_holder' => 'boolean',
            'citizenship_upload' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This ConsumerCommitteeMember has been {$eventName}");
    }
}
