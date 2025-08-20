<?php

namespace Src\Beruju\Models;

use App\Traits\HelperDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;

class Action extends Model
{
    use HasFactory, LogsActivity, HelperDate, SoftDeletes;

    protected $table = 'brj_actions';

    protected $fillable = [
        'cycle_id',
        'action_type_id',
        'status',
        'remarks',
        'resolved_amount',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'cycle_id' => 'integer',
        'action_type_id' => 'integer',
        'status' => 'string',
        'remarks' => 'string',
        'resolved_amount' => 'decimal:2',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'cycle_id',
                'action_type_id',
                'status',
                'remarks',
                'resolved_amount',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Beruju Action {$eventName}")
            ->useLogName('beruju_action');
    }

    // Relationships
    public function resolutionCycle(): BelongsTo
    {
        return $this->belongsTo(ResolutionCycle::class, 'cycle_id');
    }

    public function actionType(): BelongsTo
    {
        return $this->belongsTo(ActionType::class, 'action_type_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'Completed');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'Rejected');
    }

    // Helper methods
    public function isPending(): bool
    {
        return $this->status === 'Pending';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'Completed';
    }

    public function isRejected(): bool
    {
        return $this->status === 'Rejected';
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'Pending' => 'warning',
            'Completed' => 'success',
            'Rejected' => 'danger',
            default => 'secondary'
        };
    }
}
