<?php

namespace Src\Grievance\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class GrievanceSetting extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'gri_setting';

    protected $fillable = [
        'grievance_assigned_to',
        'escalation_days'
    ];
    protected $casts = [
        'grievance_assigned_to' => 'integer',
        'escalation_days' => 'integer'
    ];

    public function grievanceAssignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'grievance_assigned_to');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }
}
