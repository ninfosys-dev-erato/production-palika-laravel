<?php

namespace Src\Grievance\Models;

use App\Facades\FileFacade;
use App\Facades\ImageServiceFacade;
use App\Models\User;
// use App\Traits\QueryFilter;
use App\Services\ImageService;
use Carbon\Carbon;
use Database\Factories\GrievanceDetailFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Notification;
use Src\Customers\Models\Customer;
use Src\Employees\Models\Branch;
use Src\FileTracking\Models\FileRecord;
use Src\Grievance\Enums\GrievanceMediumEnum;
use Src\Grievance\Enums\GrievancePriorityEnum;
use Src\Grievance\Enums\GrievanceStatusEnum;
use Src\Grievance\Models\GrievanceTypesRole;
use Src\Grievance\Notification\GrievanceNotification;
use Src\Grievance\Service\GrievanceService;
use Src\Roles\Models\Role;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Settings\Models\FiscalYear;
use Src\Wards\Models\Ward;

class GrievanceDetail extends Model
{
    use SoftDeletes, HasFactory, LogsActivity;

    protected $table = 'gri_grievance_details';

    protected $fillable = [
        'token',
        'grievance_detail_id',
        'grievance_type_id',
        'assigned_user_id',
        'customer_id',
        'branch_id',
        'subject',
        'description',
        'status',
        'approved_at',
        'is_public',
        'grievance_medium',
        'is_anonymous',
        'priority',
        'investigation_type',
        'suggestion',
        'documents',
        'escalation_date',
        'is_visible_to_public',
        'local_body_id',
        'ward_id',
        'is_ward',
        'fiscal_year_id'
    ];
    protected $casts = [
        'token' => 'string',
        'grievance_detail_id' => 'integer',
        'grievance_type_id' => 'integer',
        'assigned_user_id' => 'integer',
        'customer_id' => 'integer',
        'branch_id' => 'integer',
        'subject' => 'string',
        'description' => 'string',
        'status' => GrievanceStatusEnum::class,
        'approved_at' => 'datetime',
        'is_public' => 'boolean',
        'grievance_medium' => GrievanceMediumEnum::class,
        'is_anonymous' => 'boolean',
        'priority' => GrievancePriorityEnum::class,
        'investigation_type' => 'string',
        'suggestions' => 'string',
        'documents' => 'array',
        'escalation_date' => 'string',
        'is_visible_to_public' => 'boolean',
        'local_body_id' => 'integer',
        'ward_id' => 'string',
        'fiscal_year_id' => 'string',
        'is_ward' => 'boolean'
    ];

    public function scopeIsAnonymous(Builder $query, bool $isAnonymous = true): Builder
    {
        return $query->where('is_anonymous', $isAnonymous);
    }


    public function scopeIsApproved(Builder $query, bool $approved = true): Builder
    {
        return $query->where('is_approved', $approved);
    }


    public function scopeIsPublic(Builder $query, bool $public = true): Builder
    {
        return $query->where('is_public', $public);
    }

    public function grievanceDetail(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'grievance_detail_id');
    }

    public function grievanceType(): BelongsTo
    {
        return $this->belongsTo(GrievanceType::class, 'grievance_type_id');
    }

    public function grievanceDetails(): HasMany
    {
        return $this->hasMany(__CLASS__, 'grievance_detail_id');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class, 'branch_grievance_detail');
    }

    public function files(): HasMany
    {
        return $this->hasMany(GrievanceFile::class, 'grievance_detail_id');
    }
    public function scopeCreatedAfter(Builder $query, $date): Builder
    {
        return $query->where('created_at', '>=', Carbon::parse($date)->startOfDay());
    }

    public function scopeCreatedBefore(Builder $query, $date): Builder
    {
        return $query->where('created_at', '<=', Carbon::parse($date)->endOfDay());
    }

    public function histories(): HasMany
    {
        return $this->hasMany(GrievanceAssignHistory::class, 'grievance_detail_id');
    }

    protected static function newFactory(): GrievanceDetailFactory|Factory
    {
        return GrievanceDetailFactory::new();
    }

    public function investigationTypes(): BelongsToMany
    {
        return $this->belongsToMany(GrievanceInvestigationType::class, 'grievance_details_investigations');
    }

    public function roles(): HasManyThrough
    {
        return $this->hasManyThrough(
            Role::class,                      // Final target model (Role)
            GrievanceTypesRole::class,        // Intermediate pivot model (GrievanceTypesRole)
            'grievance_type_id',              // Foreign key on GrievanceTypesRole (yo foreign key chai first local key)
            'id',                             // Foreign key on Role (yo chai target model ko primary key)(to GrievanceTypesRole)
            'grievance_type_id',              // Local key on GrievanceDetail  (yo model ko grievance_type_id )
            'role_id'                         // Local key on GrievanceTypesRole (to Role)
        );
    }

    public function getDocumentAttribute()
    {
        return [(new GrievanceService())->getDocuments($this)];
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

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }
    public function fiscalYear()
    {
        return $this->belongsTo(FiscalYear::class);
    }
}
