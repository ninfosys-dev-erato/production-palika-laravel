<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Wards\Models\Ward;
use Src\Yojana\Enums\AccountTypes;

class ConsumerCommittee extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_consumer_committee';

    protected $fillable = [
        'committee_type_id',
        'registration_number',
        'formation_date',
        'name',
        'ward_id',
        'address',
        'creating_body',
        'bank_id',
        'account_type',
        'account_number',
        'number_of_attendees',
        'formation_minute',
        'registration_certificate',
        'account_operation_letter',
        'account_closure_letter',
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
            'committee_type_id' => 'string',
            'registration_number' => 'string',
            'formation_date' => 'string',
            'name' => 'string',
            'ward_id' => 'string',
            'address' => 'string',
            'creating_body' => 'string',
            'bank_id' => 'string',
            'account_type' => AccountTypes::class,
            'account_number' => 'string',
            'formation_minute' => 'string',
            'number_of_attendees' => 'string',
            'id' => 'int',
            'registration_certificate' => 'string',
            'account_operation_letter' => 'string',
            'account_closure_letter' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This ConsumerCommittee has been {$eventName}");
    }

    public function committeeType() :BelongsTo
    {
        return $this->belongsTo(CommitteeType::class, 'committee_type_id');
    }

    public function ward() :BelongsTo
    {
        return $this->belongsTo(Ward::class, 'ward_id');
    }

    public function bank() :BelongsTo
    {
        return $this->belongsTo(BankDetail::class, 'bank_id');
    }

    public function getFiscalYearAttribute()
    {
        return fiscalYear();
    }
    public function getNepaliFormationDateAttribute()
    {
        return replaceNumbers(ne_date($this->formation_date),true);
    }

    public function committeeMembers() :HasMany
    {
        return $this->hasMany(ConsumerCommitteeMember::class, 'consumer_committee_id')->whereNull('deleted_at');
    }

    public function getChairmanNameAttribute(){
        return $this->committeeMembers()->where('designation', 'chair')->whereNull('deleted_at')->first()->name;
    }

    public function getSecretaryNameAttribute(){
        return $this->committeeMembers()->where('designation', 'secretary')->whereNull('deleted_at')->first()->name;
    }

    public function getTreasurerNameAttribute(){
        return $this->committeeMembers()->where('designation', 'treasurer')->whereNull('deleted_at')->first()->name;
    }

    public function getNumberOfMembersAttribute(){
        return $this->committeeMembers()->whereNull('deleted_at')->count();
    }

    public function getNumberOfMenAttribute(){
        return $this->committeeMembers()->where('gender', 'Male')->whereNull('deleted_at')->count();
    }
   
    public function getNumberOfWomenAttribute(){
        return $this->committeeMembers()->where('gender', 'Female')->whereNull('deleted_at')->count();
    }

    public function getAccountTypeLabelAttribute(){
        return $this->account_type->label();
    }
}
