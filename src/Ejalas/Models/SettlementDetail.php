<?php

namespace Src\Ejalas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SettlementDetail extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jms_settlement_details';

    protected $fillable = [
        'complaint_registration_id',
        'party_id',
        'deadline_set_date',
        'settlement_id',
        'detail',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by',
        'is_settled',
    ];


    public function casts(): array
    {
        return [
            'complaint_registration_id' => 'string',
            'party_id' => 'string',
            'detail' => 'string',
            'deadline_set_date' => 'string',
            'id' => 'int',
            'settlement_id' => 'string',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
            'is_settled' => 'boolean',
        ];
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This CaseRecord has been {$eventName}");
    }
    public function party()
    {
        return $this->belongsTo(Party::class, 'party_id', 'id');
    }
}
