<?php

namespace Src\Yojana\Models;

use App\Traits\HelperDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class Agreement extends Model
{
    use HasFactory, LogsActivity, HelperDate;

    protected $table = 'pln_agreements';

    protected $fillable = [
        'plan_id',
        'consumer_committee_id',
        'implementation_method_id',
        'plan_start_date',
        'plan_completion_date',
        'experience',
        'deposit_number',
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
            'implementation_method_id' => 'string',
            'plan_start_date' => 'string',
            'plan_completion_date' => 'string',
            'experience' => 'string',
            'deposit_number' => 'integer',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This Agreement has been {$eventName}");
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }

    public function consumerCommittee(): BelongsTo
    {
        return $this->belongsTo(ConsumerCommittee::class, 'consumer_committee_id', 'id');
    }

    public function implementationMethod(): BelongsTo
    {
        return $this->belongsTo(ImplementationMethod::class, 'implementation_method_id', 'id');
    }


    public function grants(): HasMany
    {
        return $this->hasMany(AgreementGrant::class, 'agreement_id', 'id');
    }

    public function beneficiaries(): HasMany
    {
        return $this->hasMany(AgreementBeneficiary::class, 'agreement_id', 'id');
    }

    public function signatureDetails(): HasMany
    {
        return $this->hasMany(AgreementSignatureDetail::class, 'agreement_id', 'id');
    }

    public function agreementCost(): HasOne
    {
        return $this->hasOne(AgreementCost::class, 'agreement_id', 'id');
    }

    public function installmentDetails(): HasMany
    {
        return $this->hasMany(AgreementInstallmentDetails::class, 'agreement_id', 'id');
    }

    public function getPlanStartDateNeAttribute()
    {
        // this method returns nepali date for created_at for report purpose
        return $this->adToBs($this->plan_start_date);
    }
    public function getPlanCompletionDateNeAttribute()
    {
        // this method returns nepali date for created_at for report purpose
        return $this->adToBs($this->plan_completion_date);
    }
}
