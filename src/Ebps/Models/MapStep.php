<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Settings\Models\Form;

class MapStep extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'ebps_map_steps';

    /**
     * @property int $title
     * @property bool $is_public
     * @property bool $can_skip
     * @property string $form_submitter
     * @property string $form_position
     * @property string $step_for
     * @property string $application_type
     * @property int $created_by
     * @property int $updated_by
     * @property int $deleted_by
     * @property \Carbon\Carbon|null $created_at
     * @property \Carbon\Carbon|null $updated_at
     * @property \Carbon\Carbon|null $deleted_at
     */
    protected $fillable = [
        'title',
        'is_public',
        'can_skip',
        'form_submitter',
        'form_position',
        'application_type',
        'step_for',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by',
        'position'
    ];

    public function casts(): array
    {
        return [
            'title' => 'string',
            'is_public' => 'string',
            'can_skip' => 'string',
            'form_submitter' => 'string',
            'form_position' => 'int',
            'application_type' => 'string',
            'step_for' => 'string',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
            'position' => 'int',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This MapStep has been {$eventName}");
    }

    public function form(): BelongsToMany
    {
        return $this->belongsToMany(Form::class, 'ebps_form_map_step');
    }

    public function constructionTypes(): BelongsToMany
    {
        return $this->belongsToMany(ConstructionType::class, 'ebps_construction_type_map_step');
    }

    // Group-based relationships
    public function mapPassGroups(): BelongsToMany
    {
        return $this->belongsToMany(MapPassGroup::class, 'ebps_map_pass_group_map_step', 'map_step_id', 'map_pass_group_id')
            ->withPivot('type', 'position')
            ->withTimestamps();
    }

    public function submitterGroups(): BelongsToMany
    {
        return $this->belongsToMany(MapPassGroup::class, 'ebps_map_pass_group_map_step', 'map_step_id', 'map_pass_group_id')
            ->withPivot('type', 'position')
            ->wherePivot('type', 'submitter')
            ->orderBy('position');
    }

    public function approverGroups(): BelongsToMany
    {
        return $this->belongsToMany(MapPassGroup::class, 'ebps_map_pass_group_map_step', 'map_step_id', 'map_pass_group_id')
            ->withPivot('type', 'position')
            ->wherePivot('type', 'approver')
            ->orderBy('position');
    }

    public function mapPassGroupMapSteps(): HasMany
    {
        return $this->hasMany(MapPassGroupMapStep::class, 'map_step_id');
    }

    // Methods for checking user access based on groups
    public function canUserSubmit($user): bool
    {
        if ($this->form_submitter === 'Consultancy' || $this->form_submitter === 'Ghardhani') {
            return false; // No submitter needed for these types
        }

        if ($this->form_submitter === 'Palika') {
            return $this->submitterGroups()
                ->whereHas('users', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->exists();
        }

        return false;
    }

    public function canUserApprove($user): bool
    {
        return $this->approverGroups()
            ->whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->exists();
    }

    public function canUserAccess($user): bool
    {
        return $this->canUserSubmit($user) || $this->canUserApprove($user);
    }

    // Get users who can submit this step
    public function getSubmitterUsers()
    {
        return $this->submitterGroups()
            ->with('users.user')
            ->get()
            ->flatMap(function ($group) {
                return $group->users->pluck('user');
            })
            ->unique('id');
    }

    // Get users who can approve this step
    public function getApproverUsers()
    {
        return $this->approverGroups()
            ->with('users.user')
            ->get()
            ->flatMap(function ($group) {
                return $group->users->pluck('user');
            })
            ->unique('id');
    }

    // Scopes for filtering steps based on user groups
    public function scopeAccessibleByUser($query, $user)
    {
        return $query->whereHas('mapPassGroupMapSteps', function ($q) use ($user) {
            $q->whereHas('mapPassGroup.users', function ($userQuery) use ($user) {
                $userQuery->where('user_id', $user->id);
            });
        });
    }

    public function scopeForApplicationType($query, $applicationType)
    {
        return $query->where('application_type', $applicationType);
    }

    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at')->whereNull('deleted_by');
    }

    // Helper methods for step management
    public function assignSubmitterGroup($groupId, $position = 1)
    {
        // Remove existing submitter groups
        $this->mapPassGroupMapSteps()
            ->where('type', 'submitter')
            ->delete();

        // Add new submitter group
        return $this->mapPassGroupMapSteps()->create([
            'map_pass_group_id' => $groupId,
            'type' => 'submitter',
            'position' => $position,
        ]);
    }

    public function assignApproverGroups(array $groupIds)
    {
        // Remove existing approver groups
        $this->mapPassGroupMapSteps()
            ->where('type', 'approver')
            ->delete();

        // Add new approver groups
        foreach ($groupIds as $position => $groupId) {
            $this->mapPassGroupMapSteps()->create([
                'map_pass_group_id' => $groupId,
                'type' => 'approver',
                'position' => $position + 1,
            ]);
        }
    }
}
