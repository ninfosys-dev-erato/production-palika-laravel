<?php

namespace Src\Beruju\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;
use Src\Beruju\Models\BerujuEntry;

class ResolutionCycle extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'brj_resolution_cycles';

    protected $fillable = [
        'beruju_id',
        'incharge_id',
        'assigned_by',
        'assigned_at',
        'status',
        'remarks',
        'completed_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'beruju_id' => 'integer',
        'incharge_id' => 'integer',
        'assigned_by' => 'integer',
        'assigned_at' => 'datetime',
        'status' => 'string',
        'remarks' => 'string',
        'completed_at' => 'datetime',
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
                'beruju_id',
                'incharge_id',
                'assigned_by',
                'assigned_at',
                'status',
                'remarks',
                'completed_at',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Resolution Cycle {$eventName}")
            ->useLogName('resolution_cycle');
    }

    // Relationships
    public function berujuEntry(): BelongsTo
    {
        return $this->belongsTo(BerujuEntry::class, 'beruju_id');
    }

    public function incharge(): BelongsTo
    {
        return $this->belongsTo(User::class, 'incharge_id');
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
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

    public function actions(): HasMany
    {
        return $this->hasMany(\Src\Beruju\Models\Action::class, 'cycle_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    // Accessors
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'active' => '#28a745',
            'completed' => '#17a2b8',
            'rejected' => '#dc3545',
            'inactive' => '#6c757d',
            default => '#6c757d',
        };
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active';
    }

    public function getIsCompletedAttribute(): bool
    {
        return $this->status === 'completed';
    }

    public function getIsRejectedAttribute(): bool
    {
        return $this->status === 'rejected';
    }

    public function getIsInactiveAttribute(): bool
    {
        return $this->status === 'inactive';
    }

}
