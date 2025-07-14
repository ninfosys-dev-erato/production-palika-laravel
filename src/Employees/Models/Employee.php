<?php

namespace Src\Employees\Models;

use App\Models\User;
use Database\Factories\EmployeeFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Src\Employees\Enums\GenderEnum;
use Src\Employees\Enums\TypeEnum;
use Src\TaskTracking\Models\EmployeeMarkingScore;

class Employee extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'mst_employees';

    protected $fillable = [
        'name',
        'address',
        'gender',
        'pan_no',
        'is_department_head',
        'photo',
        'email',
        'phone',
        'type',
        'remarks',
        'user_id',
        'branch_id',
        'ward_no',
        'designation_id',
        'position',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];

    protected $casts = [
        'name' => 'string',
        'address' => 'string',
        'gender' => GenderEnum::class,
        'pan_no' => 'string',
        'is_department_head' => 'boolean',
        'photo' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'type' => TypeEnum::class,
        'remarks' => 'string',
        'user_id' => 'integer',
        'branch_id' => 'integer',
        'ward_no' => 'string',
        'designation_id' => 'integer',
        'position' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
        'deleted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class);
    }

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
    protected static function newFactory(): EmployeeFactory|Factory
    {
        return EmployeeFactory::new();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }
    public function markings()
    {
        return $this->hasMany(EmployeeMarkingScore::class);
    }
}
