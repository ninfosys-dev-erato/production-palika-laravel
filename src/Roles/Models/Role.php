<?php

namespace Src\Roles\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Models\Role as ModelsRole;
use Src\Grievance\Models\GrievanceType;
use Src\Recommendation\Models\Recommendation;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class Role extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'roles';

    protected $fillable = [
        'name',
        'guard_name',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by',
    ];

    public function casts(): array
    {
        return [
            'name' => 'string',
            'guard_name' => 'string',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
        ];
    }

    public function grievanceTypes()
    {
        return $this->belongsToMany(GrievanceType::class, 'tbl_grievance_types_roles');
    }

    public function recommendations()
    {
        return $this->belongsToMany(Recommendation::class, 'tbl_recommendations_roles');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }
}
