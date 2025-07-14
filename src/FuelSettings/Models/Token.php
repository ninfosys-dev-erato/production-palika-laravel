<?php

namespace Src\FuelSettings\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Token extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'fms_tokens';

    protected $fillable = [
        'token_no',
        'fiscal_year_id',
        'tokenable_type',
        'tokenable_id',
        'organization_id',
        'fuel_quantity',
        'fuel_type',
        'status',
        'accepted_at',
        'accepted_by',
        'reviewed_at',
        'reviewed_by',
        'expires_at',
        'redeemed_at',
        'redeemed_by',
        'ward_no',
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
            'token_no' => 'string',
            'fiscal_year_id' => 'string',
            'tokenable_type' => 'string',
            'tokenable_id' => 'string',
            'organization_id' => 'string',
            'fuel_quantity' => 'string',
            'fuel_type' => 'string',
            'status' => 'string',
            'accepted_at' => 'string',
            'accepted_by' => 'string',
            'reviewed_at' => 'string',
            'reviewed_by' => 'string',
            'expires_at' => 'string',
            'redeemed_at' => 'string',
            'redeemed_by' => 'string',
            'ward_no' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This Token has been {$eventName}");
    }
}
