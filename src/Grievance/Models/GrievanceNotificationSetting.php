<?php

namespace Src\Grievance\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class GrievanceNotificationSetting extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'gri_grievance_notification_settings';

    protected $fillable = [
        'module',
        'mail',
        'sms',
        'fcm',
    ];
    protected $casts = [
        'module' => 'string',
        'mail' => 'boolean',
        'sms' => 'boolean',
        'fcm' => 'boolean',
    ];


public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()
        ->logFillable()
        ->logOnlyDirty()
        ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
}


}