<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ImplementationQuotation extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_implementation_quotations';

    protected $fillable = [
        'implementation_agency_id',
        'name',
        'address',
        'amount',
        'date',
        'percentage',
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
            'name' => 'string',
            'address' => 'string',
            'amount' => 'int',
            'date' => 'string',
            'percentage' => 'int',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This Implementation quotation has been {$eventName}");
    }

    public function implementation_agency(): belongsTo
    {
        return $this->belongsTo(ImplementationAgency::class, 'implementation_agency_id');
    }

}
