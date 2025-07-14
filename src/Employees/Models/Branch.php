<?php

namespace Src\Employees\Models;

use App\Models\User;
use Database\Factories\BranchFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\BusinessRegistrationAndRenewal\Models\RegistrationType;
use Src\FileTracking\Models\FileRecord;
use Src\Grievance\Models\GrievanceDetail;
use Src\Grievance\Models\GrievanceType;
use Src\Recommendation\Models\Recommendation;
use Src\Yojana\Models\Plan;

class Branch extends Model
{
    use SoftDeletes, HasFactory, LogsActivity;

    protected $table = 'mst_branches';

    protected $fillable = [
        'title',
        'title_en',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'title' => 'string',
        'title_en' => 'string',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
        'deleted_at' => 'datetime',
    ];


    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    protected static function newFactory(): Factory|BranchFactory
    {
        return BranchFactory::new();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tbl_users_departments')
            ->withPivot('is_department_head')
            ->withTimestamps();
    }

    public function grievanceTypes(): BelongsToMany
    {
        return $this->belongsToMany(GrievanceType::class, 'tbl_grievance_types_branches');
    }

    public function recommendations(): BelongsToMany
    {
        return $this->belongsToMany(Recommendation::class, 'rec_recommendations_departments');
    }


    public function files()
    {
        return $this->belongsToMany(FileRecord::class, 'tbl_files_departments', 'department_id', 'file_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }

    public function grievances(): BelongsToMany
    {
        return $this->belongsToMany(GrievanceDetail::class, 'branch_grievance_detail');
    }

    public function getDisplayNameAttribute()
    {
        return app()->getLocale() === "en" ? ($this->title_en ?? $this->title) : ($this->title_np ?? $this->title);
    }

    public function registrationTypes(): HasMany
{
    return $this->hasMany(RegistrationType::class, 'department_id');
}

    public function plans() :HasMany
    {
        return $this->hasMany(Plan::class, 'department');
    }


}
