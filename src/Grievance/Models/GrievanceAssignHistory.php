<?php

namespace Src\Grievance\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class GrievanceAssignHistory extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'gri_grievance_assign_histories';

    protected $fillable = [
        'grievance_detail_id',
        'from_user_id',
        'to_user_id',
        'old_status',
        'new_status',
        'documents',
        'suggestions',
    ];
    protected $casts = [
        'grievance_detail_id' => 'integer',
        'from_user_id' => 'integer',
        'to_user_id' => 'integer',
        'old_status' => 'string',
        'new_status' => 'string',
        'documents' => 'array',
        'suggestions' => 'string',
    ];

    public function grievanceDetail(): BelongsTo
    {
        return $this->belongsTo(GrievanceDetail::class, 'grievance_detail_id');
    }

    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }

}
