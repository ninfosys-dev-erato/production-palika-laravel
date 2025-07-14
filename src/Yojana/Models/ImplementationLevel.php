<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ImplementationLevel extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_implementation_level';

    protected $fillable = [
        'title',
        'code',
        'threshold',
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
            'code' => 'string',
            'threshold' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This ImplementationLevel has been {$eventName}");
    }

    public function plans(): HasMany
    {
        return $this->hasMany(Plan::class);
    }

    public function budgetSources() : HasMany
    {
        return $this->hasMany(ImplementationLevel::class, 'level_id', 'id');
    }
}
