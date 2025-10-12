<?php

namespace Src\Ejalas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Ejalas\Enum\PlaceOfRegistration;
use Src\FiscalYears\Models\FiscalYear;

class ComplaintRegistration extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jms_complaint_registrations';

    protected $fillable = [
        'fiscal_year_id',
        'reg_no',
        'old_reg_no',
        'reg_date',
        'reg_address',
        'complainer_id',
        'defender_id',
        'priority_id',
        'dispute_matter_id',
        'subject',
        'description',
        'claim_request',
        'status',
        'reconciliation_center_id',
        'reconciliation_reg_no',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'template',
        'updated_by'
    ];

    public function casts(): array
    {
        return [
            'fiscal_year_id' => 'string',
            'reg_no' => 'string',
            'old_reg_no' => 'string',
            'reg_date' => 'string',
            'reg_address' => PlaceOfRegistration::class,
            'complainer_id' => 'string',
            'defender_id' => 'string',
            'priority_id' => 'string',
            'dispute_matter_id' => 'string',
            'subject' => 'string',
            'description' => 'string',
            'claim_request' => 'string',
            'reconciliation_center_id' => 'string',
            'reconciliation_reg_no' => 'string',
            'status' => 'boolean',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
            'template' => 'string',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This ComplaintRegistration has been {$eventName}");
    }
    public function fiscalYear()
    {
        return $this->belongsTo(FiscalYear::class, 'fiscal_year_id', 'id');
    }
    public function priority()
    {
        return $this->belongsTo(Priotity::class, 'priority_id', 'id');
    }
    public function disputeMatter()
    {
        return $this->belongsTo(DisputeMatter::class, 'dispute_matter_id', 'id');
    }


    // public function parties()
    // {
    //     return $this->hasMany(Party::class, 'reg_id', 'reg_no');
    // }
    public function parties()
    {
        return $this->belongsToMany(Party::class, 'complaint_party', 'complaint_id', 'party_id')
            ->withPivot('type')
            ->withTimestamps();
    }

    // Additional relationships for template placeholders
    public function hearingSchedule()
    {
        return $this->hasMany(HearingSchedule::class, 'complaint_registration_id', 'id');
    }

    public function courtNotice()
    {
        return $this->hasMany(CourtNotice::class, 'complaint_registration_id', 'id');
    }

    public function writtenResponseRegistration()
    {
        return $this->hasMany(WrittenResponseRegistration::class, 'complaint_registration_id', 'id');
    }

    public function mediatorSelection()
    {
        return $this->hasMany(MediatorSelection::class, 'complaint_registration_id', 'id');
    }

    public function witnessesRepresentative()
    {
        return $this->hasMany(WitnessesRepresentative::class, 'complaint_registration_id', 'id');
    }

    public function settlement()
    {
        return $this->hasMany(Settlement::class, 'complaint_registration_id', 'id');
    }

    public function caseRecord()
    {
        return $this->hasMany(CaseRecord::class, 'complaint_registration_id', 'id');
    }

    public function disputeDeadline()
    {
        return $this->hasMany(DisputeDeadline::class, 'complaint_registration_id', 'id');
    }

    public function disputeRegistrationCourt()
    {
        return $this->hasMany(DisputeRegistrationCourt::class, 'complaint_registration_id', 'id');
    }
}
