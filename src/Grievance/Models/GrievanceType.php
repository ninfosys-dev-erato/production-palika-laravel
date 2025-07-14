<?php

namespace Src\Grievance\Models;

use Database\Factories\GrievanceTypeFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Src\Employees\Models\Branch;
use Src\Roles\Models\Role;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class GrievanceType extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'gri_grievance_types';

    protected $fillable = [
        'title',
        'is_ward',
        'deleted_at'
    ];
    protected $casts = [
        'title' => 'string',
    ];

    public function grievanceDetails(): HasMany
    {
        return $this->hasMany(GrievanceDetail::class, 'grievance_type_id');
    }

    protected static function newFactory(): GrievanceTypeFactory|Factory
    {
        return GrievanceTypeFactory::new();
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'tbl_grievance_types_roles');
    }

    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class, 'tbl_grievance_types_branches');
    }
    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class, 'tbl_grievance_types_branches', 'grievance_type_id', 'branch_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }

}
