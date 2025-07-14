<?php

namespace Src\BusinessRegistration\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\BusinessRegistration\Enums\BusinessRegistrationType;
use Src\Employees\Models\Branch;
use Src\Settings\Models\Form;

class RegistrationType extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = "brs_registration_types";

    protected $fillable = [
        'title',
        'form_id',
        'registration_category_id',
        'department_id',
        'registration_category_enum',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by',
        'action',
    ];

    protected function casts(): array
    {
        return [
            'title' => 'string',
            'form_id' => 'string',
            'registration_category_id' => 'string',
            'department_id' => 'string',
            'registration_category_enum' => 'string',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
            'action' => BusinessRegistrationType::class,
        ];
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function registrationCategory(): BelongsTo
    {
        return $this->belongsTo(RegistrationCategory::class, 'registration_category_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This Partner has been {$eventName}");
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'department_id');
    }


    public function businessRegistrations()
    {
        return $this->hasMany(BusinessRegistration::class, 'registration_type_id');
    }

    public function businessRegistrationCount()
    {
        return $this->businessRegistrations()->count();
    }
}
