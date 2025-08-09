<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Settings\Models\Form;
use Spatie\Permission\Models\Role;

class MapStep extends Model
{
    use HasFactory,LogsActivity;

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
        'updated_by'
    ];

    public function casts():array{
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
    
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(MapPassGroup::class, 'ebps_map_pass_group_map_step');
    }

    // New role-based relationships
    public function stepRoles(): HasMany
    {
        return $this->hasMany(StepRole::class, 'map_step_id');
    }

    public function submitterRoles(): HasMany
    {
        return $this->hasMany(StepRole::class, 'map_step_id')->submitters()->active();
    }

    public function approverRoles(): HasMany
    {
        return $this->hasMany(StepRole::class, 'map_step_id')->approvers()->active();
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'ebps_step_roles', 'map_step_id', 'role_id')
                    ->withPivot('role_type', 'position', 'is_active')
                    ->withTimestamps();
    }

    // Methods for checking user access
    public function canUserSubmit($user): bool
    {
        if ($this->form_submitter === 'Consultancy' || $this->form_submitter === 'Ghardhani') {
            return false; // No submitter needed for these types
        }

        if ($this->form_submitter === 'Palika') {
            return $this->submitterRoles()
                ->whereHas('role', function ($query) use ($user) {
                    $query->whereIn('name', $user->getRoleNames()->toArray());
                })
                ->exists();
        }

        return false;
    }

    public function canUserApprove($user): bool
    {
        return $this->approverRoles()
            ->whereHas('role', function ($query) use ($user) {
                $query->whereIn('name', $user->getRoleNames()->toArray());
            })
            ->exists();
    }

    public function canUserAccess($user): bool
    {
        return $this->canUserSubmit($user) || $this->canUserApprove($user);
    }

    // Scopes for filtering steps based on user roles
    public function scopeAccessibleByUser($query, $user)
    {
        return $query->whereHas('stepRoles', function ($q) use ($user) {
            $q->active()->whereHas('role', function ($roleQuery) use ($user) {
                $roleQuery->whereIn('name', $user->getRoleNames()->toArray());
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
}
