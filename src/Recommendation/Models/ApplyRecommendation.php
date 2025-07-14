<?php

namespace Src\Recommendation\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Src\Customers\Models\Customer;
use Src\FileTracking\Models\FileRecord;
use Src\FiscalYears\Models\FiscalYear;
use Src\Recommendation\Enums\RecommendationStatusEnum;
use Src\Recommendation\Services\RecommendationService;
use Src\Roles\Models\Role;
use Src\Settings\Models\Form;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ApplyRecommendation extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'rec_apply_recommendations';
    protected $fillable = [
        'customer_id',
        'recommendation_id',
        'data',
        'status',
        'remarks',
        'created_by',
        'updated_by',
        'deleted_by',
        'reviewed_by',
        'reviewed_at',
        'accepted_by',
        'accepted_at',
        'rejected_by',
        'rejected_at',
        'rejected_reason',
        'bill',
        'ltax_ebp_code',
        'local_body_id',
        'ward_id',
        'is_ward',
        "additional_letter",
        "signee_id",
        "signee_type",
        'fiscal_year_id',
        'recommendation_medium'
    ];
    protected $casts = [
        'customer_id' => 'integer',
        'recommendation_id' => 'integer',
        'data' => 'json',
        'status' => RecommendationStatusEnum::class,
        'remarks' => 'string',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
        'reviewed_by' => 'integer',
        'reviewed_at' => 'datetime',
        'accepted_by' => 'integer',
        'accepted_at' => 'datetime',
        'rejected_by' => 'integer',
        'rejected_at' => 'datetime',
        'rejected_reason' => 'string',
        'ltax_ebp_code' => 'string',
        'local_body_id' => 'integer',
        'ward_id' => 'string',
        'is_ward' => 'boolean',
        'additional_letter' => 'string',
        'signee_id' => 'integer',
        'signee_type' => 'string',
        'fiscal_year_id' => 'int',
        'recommendation_medium' => 'string'
    ];

    public function signee(): MorphTo
    {
        return $this->morphTo();
    }
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function recommendation(): BelongsTo
    {
        return $this->belongsTo(Recommendation::class, 'recommendation_id');
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
    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function acceptedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'accepted_by');
    }

    public function rejectedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }
    public function documents()
    {
        return $this->hasMany(ApplyRecommendationDocument::class, 'apply_recommendation_id');
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function roles(): HasManyThrough
    {
        return $this->hasManyThrough(
            Role::class,
            RecommendationsRoles::class,
            'recommendation_id',
            'id',
            'recommendation_id',
            'role_id'
        );
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }

    public function records(): MorphMany
    {
        return $this->morphMany(FileRecord::class, 'subject');
    }

    public function fiscalYear()
    {
        return $this->belongsTo(FiscalYear::class);
    }

    public function getDocumentAttribute()
    {
        return [(new RecommendationService())->getLetter($this, 'api')];
    }

}
