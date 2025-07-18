<?php

namespace Src\DigitalBoard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class NoticeWard extends Model
{
    use HasFactory, LogsActivity;

    protected $table = "tbl_notice_wards";

    protected $fillable = [
        'notice_id',
        'ward',
    ];

    public function notice(): BelongsTo
    {
        return $this->belongsTo(Notice::class, 'notice_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }


}
