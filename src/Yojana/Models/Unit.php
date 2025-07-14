<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Unit extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_units';

    protected $fillable = [
        'symbol',
        'title',
        'title_ne',
        'type_id',
        'will_be_in_use',
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
            'type_id' => 'string',
            'measurement_unit_id' => 'string',
            'title' => 'string',
            'position' => 'string',
            'is_smallest' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This Unit has been {$eventName}");
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function measurementUnit(): BelongsTo
    {
        return $this->belongsTo(MeasurementUnit::class);
    }
    public function activity()
    {
        return $this->hasMany(Activity::class);
    }
    public function processIndicators(): HasMany
    {
        return $this->hasMany(ProcessIndicator::class);
    }
}
