<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ImplementationContractDetails extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_implementation_contract_details';

    protected $fillable = [
        'implementation_agency_id',
        'contract_number',
        'notice_date',
        'bid_acceptance_date',
        'bid_amount',
        'deposit_amount',
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
            'implementation_agency_id' => 'int',
            'contract_number' => 'int',
            'notice_date' => 'string',
            'bid_acceptance_date' => 'string',
            'bid_amount' => 'int',
            'deposit_amount' => 'int',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This Implementation Contract Detail has been {$eventName}");
    }
}
