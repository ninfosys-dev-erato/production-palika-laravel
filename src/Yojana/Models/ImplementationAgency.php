<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ImplementationAgency extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_implementation_agencies';

    protected $fillable = [
        'plan_id',
        'consumer_committee_id',
        'organization_id',
        'application_id',
        'model',
        'comment',
        'agreement_application',
        'agreement_recommendation_letter',
        'deposit_voucher',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by'
    ];

    public function casts(): array
    {
        return [
            'plan_id' => 'string',
            'consumer_committee_id' => 'string',
            'model' => 'string',
            'comment' => 'string',
            'agreement_application' => 'string',
            'agreement_recommendation_letter' => 'string',
            'deposit_voucher' => 'string',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This ImplementationAgency has been {$eventName}");
    }
    public function consumerCommittee()
    {
        return $this->belongsTo(ConsumerCommittee::class, 'consumer_committee_id', 'id');
    }
    public function implementationMethod()
    {
        return $this->belongsTo(ImplementationMethod::class, 'model', 'id');
    }

    public function implementationContractDetail(): HasOne
    {
        return $this->hasOne(ImplementationContractDetails::class, 'implementation_agency_id', 'id');
    }

    public function organization() :BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function application() :BelongsTo{
        return $this->belongsTo(Application::class, 'application_id', 'id');
    }

    public function quotations():HasMany{
        return $this->hasMany(ImplementationQuotation::class, 'implementation_agency_id', 'id');
    }

    public function plan() : BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }
}
