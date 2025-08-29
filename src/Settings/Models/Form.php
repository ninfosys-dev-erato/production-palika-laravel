<?php

namespace Src\Settings\Models;

use App\Models\User;
use Database\Factories\FormFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Src\Ebps\Models\MapStep;
use Src\Settings\Enums\ModuleEnum;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Src\Ebps\Models\AdditionalForm;

class Form extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'mst_forms';

    protected $fillable = [
        'title',
        'template',
        'styles',
        'created_by',
        'updated_by',
        'deleted_by',
        'fields',
        'module'
    ];

    protected $casts = [
        'title' => 'string',
        'template' => 'string',
        'styles' => 'string',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
        'module' => ModuleEnum::class,
        'fields' => 'array'
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

    protected static function newFactory(): FormFactory|Factory
    {
        return FormFactory::new();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }

    public function steps(): BelongsToMany
    {
        return $this->belongsToMany(MapStep::class, 'ebps_form_map_step');
    }
    public function additionalForm(): HasOne
    {
        return $this->hasOne(AdditionalForm::class);
    }
}
