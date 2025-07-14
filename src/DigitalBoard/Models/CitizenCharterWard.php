<?php

namespace Src\DigitalBoard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CitizenCharterWard extends Model
{
    use HasFactory, LogsActivity;

    protected $table = "tbl_citizen_charter_wards";

    protected $fillable = [
        'citizen_charter_id',
        'ward'
    ];

    public function citizenCharter(): BelongsTo
    {
        return $this->belongsTo(CitizenCharter::class, 'citizen_charter_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }
}
