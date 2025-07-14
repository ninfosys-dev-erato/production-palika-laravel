<?php

namespace Src\TokenTracking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Employees\Models\Branch;
use Src\TokenTracking\Enums\TokenPurposeEnum;


class RegisterToken extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'tok_register_tokens';

    protected $fillable = [
        'token',
        'token_purpose',
        'fiscal_year',
        'status',
        'date',
        'date_en',
        'current_branch',
        'stage',
        'entry_time',
        'exit_time',
        'estimated_time',
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
            'token' => 'string',
            'token_purpose' => TokenPurposeEnum::class,
            'fiscal_year' => 'string',
            'date' => 'string',
            'date_en' => 'string',
            'current_branch' => 'string',
            'entry_time' => 'string',
            'exit_time' => 'string',
            'estimated_time' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This RegisterToken has been {$eventName}");
    }

    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class, 'tok_branch_register_tokens', 'register_token_id', 'branch_id');
    }

    public function currentBranch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'current_branch');
    }

    public function getTokenPurposeLabelAttribute()
    {
        return $this->token_purpose?->label()?? __('Unknown');
    }

    public function tokenHolder()
    {
        return $this->hasOne(TokenHolder::class, 'token_id');
    }

    public function stageStatus()
    {
        return $this->hasMany(TokenStageStatus::class, 'token_id');
    }
    public function feedback()
    {
        return $this->hasMany(TokenFeedback::class, 'token_id');
    }
    public function logs(): HasMany
    {
        return $this->hasMany(RegisterTokenLog::class, 'token_id');
    }

    // Boot method to listen for updates
    protected static function booted()
    {

        static::updating(function ($registerToken) {
            // Compare old and new values, then log the changes
            $dirtyAttributes = $registerToken->getDirty();
            $changedKeys = array_keys($dirtyAttributes);

            $changedLabels = array_map(function ($key) {
                return ucwords(str_replace('_', ' ', $key)); // e.g. "current_branch" => "Current Branch"
            }, $changedKeys);

            $fieldsChanged = implode(', ', $changedLabels);

            $description = $fieldsChanged . ' ' . (count($changedLabels) > 1 ? 'have' : 'has') . ' been updated by ' . Auth::user()?->id;

            // Check if there were any changes
            if (!empty($dirtyAttributes)) {
                $oldValues = $registerToken->fresh()->toArray();
                // Create the log entry
                RegisterTokenLog::create([
                    'token_id' => $registerToken->id,
                    'old_stage' => $oldValues['stage'] ?? null,
                    'current_stage' => $dirtyAttributes['stage'] ?? null,
                    'old_status' => $oldValues['status'] ?? null,
                    'current_status' =>($dirtyAttributes['status'])->value ?? null,
                    'old_branch' => $oldValues['current_branch'] ?? null,
                    'current_branch' => $dirtyAttributes['current_branch'] ?? null,
                    'old_values' => json_encode($oldValues),
                    'current_values' => json_encode($dirtyAttributes), // or just $registerToken->getAttributes()
                    'description' => $description,
                    'created_by' => Auth::user()?->id,
                    'updated_by' => Auth::user()?->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }


    public function getBranchFlowString(): string
    {
        $logs = $this->logs()
            ->with('oldBranch', 'currentBranch')
            ->whereNotNull('old_branch')
            ->whereNotNull('current_branch')
            ->orderBy('created_at')
            ->get();

        $flow = [];
        if($logs->isNotEmpty()) {
            foreach ($logs as $log) {
                $from = $log->oldBranch?->title ?? $log->old_branch;
                $to = $log->currentBranch?->title ?? $log->current_branch;

                if (empty($flow) || end($flow) !== $from) {
                    $flow[] = $from;
                }

                $flow[] = $to;
            }

            // Optional: remove consecutive duplicates (if needed)
            $flow = array_values(array_filter(array_unique($flow), fn($b) => !is_null($b)));

            return implode(' → ', $flow);
        }else{
            return $this->currentBranch?->title ?? __('Unknown');
        }

    }


}
