<?php

namespace Src\Recommendation\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Src\Employees\Models\Branch;
use Src\Roles\Models\Role;
use Src\Settings\Models\Form;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class Recommendation extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'rec_recommendations';


    protected $fillable = [
        'title',
        'recommendation_category_id',
        'form_id',
        'revenue',
        'is_ward_recommendation',
        'notify_to',
        'accepted_by',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'title' => 'string',
        'recommendation_category_id' => 'integer',
        'form_id' => 'integer',
        'revenue' => 'integer',
        'is_ward_recommendation' => 'boolean',
        'notify_to' => 'integer',
        'accepted_by' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
    ];

    public function recommendationCategory(): BelongsTo
    {
        return $this->belongsTo(RecommendationCategory::class, 'recommendation_category_id');
    }


    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class, 'form_id');
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

    public function recommendationDocuments(): HasMany
    {
        return $this->hasMany(RecommendationDocument::class);
    }

    public function applyRecommendations(): HasMany
    {
        return $this->hasMany(ApplyRecommendation::class);
    }

    public function notifyTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'notify_to');
    }

    public function acceptedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'accepted_by');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'tbl_recommendations_roles');
    }

    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class, 'rec_recommendations_departments');
    }

    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class, 'rec_recommendations_departments', 'recommendation_id', 'branch_id');
    }

    public function signees(): HasMany
    {
        return $this->hasMany(RecommendationSigneesUser::class, 'recommendation_type_id');
    }


public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()
        ->logFillable()
        ->logOnlyDirty()
        ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
}
}

