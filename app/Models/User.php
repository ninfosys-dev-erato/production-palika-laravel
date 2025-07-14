<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Src\Employees\Models\Branch;
use Src\Employees\Models\Employee;
use Src\FileTracking\Models\FileRecord;
use Src\FileTracking\Models\FileRecordLog;
use Src\FuelSettings\Models\FuelSetting;
use Src\Grievance\Models\GrievanceType;
use Src\TaskTracking\Models\Attachment;
use Src\TaskTracking\Models\Task;
use Src\Users\Models\UserWard;
use Src\Yojana\Models\BudgetTransfer;
use Src\Yojana\Models\Plan;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasPermissions, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'signature',
        'active',
        'mobile_no',
        'deleted_at',
        'deleted_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }

        return null; // see the note above in Gate::before about why null must be returned here.
    }

    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class, 'tbl_users_departments')->withPivot('is_department_head')->withTimestamps();
    }

    public function userWards(): HasMany
    {
        return $this->hasMany(UserWard::class, 'user_id');
    }


    public function wards(): BelongsToMany
    {
        return $this->belongsToMany(
            \Src\Wards\Models\Ward::class,  // related model
            'tbl_users_wards',              // pivot table name
            'user_id',                      // foreign key on the pivot table for the user
            'ward'                          // foreign key on the pivot table for the ward
        );
    }


    public function assignedTask(): MorphMany
    {
        return $this->morphMany(Task::class, 'assignee');
    }

    public function reportedTasks(): MorphMany
    {
        return $this->morphMany(Task::class, 'reporter');
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function records(): MorphMany
    {
        return $this->morphMany(FileRecord::class, 'sender');
    }
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
    public function logs()
    {
        return $this->morphMany(FileRecordLog::class, 'handler');
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->name;
    }

    public function operatedBusinesses()
    {
        return $this->hasMany(BusinessRegistration::class, 'operator_id');
    }

    public function preparedBusinesses()
    {
        return $this->hasMany(BusinessRegistration::class, 'preparer_id');
    }

    public function approvedBusinesses()
    {
        return $this->hasMany(BusinessRegistration::class, 'approver_id');
    }
    public function fuelSettingsAcceptor()
    {
        return $this->hasMany(FuelSetting::class, 'acceptor_id');
    }
    public function fuelSettingsReviewer()
    {
        return $this->hasMany(FuelSetting::class, 'reviewer_id');
    }

    public function budgetTransfer() : HasMany
    {
        return $this->hasMany(BudgetTransfer::class);
    }
    public function hasTokenPermission(string $permission): bool
    {
        // For token-authenticated users only
        if (request()->user() && method_exists(request()->user(), 'tokenCan')) {
            return $this->tokenCan($permission);
        }

        return false;
    }

}
