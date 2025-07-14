<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ConsumerCommitteeOfficial extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'pln_consumer_committee_officials';

    protected $fillable = [
'consumer_committee_id',
'post',
'name',
'father_name',
'grandfather_name',
'address',
'gender',
'phone',
'citizenship_no',
'created_at',
'created_by',
'deleted_at',
'deleted_by',
'updated_at',
'updated_by'
];

    public function casts():array{
      return [
    'consumer_committee_id' => 'string',
    'post' => 'string',
    'name' => 'string',
    'father_name' => 'string',
    'grandfather_name' => 'string',
    'address' => 'string',
    'gender' => 'string',
    'phone' => 'string',
    'citizenship_no' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This ConsumerCommitteeOfficial has been {$eventName}");
        }

}
