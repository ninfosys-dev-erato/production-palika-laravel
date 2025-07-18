<?php

namespace Src\DigitalBoard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PopupWard extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'tbl_popup_wards';

    protected $fillable = [
        'popup_id',
        'ward'
    ];

    public function popup(): BelongsTo
    {
        return $this->belongsTo(PopUp::class, 'popup_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }
}
