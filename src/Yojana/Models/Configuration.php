<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Configuration extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_configurations';

    protected $fillable = [
        'title',
        'amount',
        'rate',
        'type_id',
        'use_in_cost_estimation',
        'use_in_payment',
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
            'amount' => 'string',
            'rate' => 'integer',
            'type_id' => 'integer',
            'use_in_cost_estimation' => 'boolean',
            'use_in_payment' => 'boolean',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This Configuration has been {$eventName}");
    }
    public function Type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function taxDeductions() : HasMany
    {
        return $this->hasMany(PaymentTaxDeduction::class, 'name');
    }

}
