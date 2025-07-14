<?php

namespace Src\GrantManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Employees\Models\Branch;
use Src\Settings\Models\FiscalYear;

/**
 * @property string $title
 * @property string $title_en
 * @property string|null $grant_amount
 * @property string|null $program_name
 * @property array|null $for_grant
 * @property string|null $condition
 * @property int|null $fiscal_year_id
 * @property int|null $type_of_grant_id
 * @property int|null $granting_organization_id
 * @property int|null $branch_id
 * @property string|null $created_at
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property string|null $updated_at
 * @property string|null $updated_by
 */

class GrantProgram extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'gms_grant_programs';

    protected $fillable = [
        'title',
        'title_en',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by',
        'fiscal_year_id',
        'grant_provided_type',
        'type_of_grant_id',
        'program_name',
        'for_grant',
        'grant_provided',
        'grant_provided_quantity',
        'granting_organization_id',
        'branch_id',
        'grant_amount',
        'condition',
    ];

    protected $casts = [
        'grant_amount' => 'string',
        'fiscal_year_id' => 'integer',
        'type_of_grant_id' => 'integer',
        'granting_organization_id' => 'integer',
        'branch_id' => 'integer',
        'program_name' => 'string',
        'for_grant' => 'array',
        'condition' => 'string',
        'grant_provided_type' => 'string',
        'grant_provided' => 'string',
        'grant_provided_quantity' => 'string',
        'created_at' => 'datetime',
        'created_by' => 'string',
        'deleted_at' => 'datetime',
        'deleted_by' => 'string',
        'updated_at' => 'datetime',
        'updated_by' => 'string',
    ];



    public function fiscalYear()
    {
        return $this->belongsTo(FiscalYear::class);
    }

    public function grantProgram(){
        return $this->belongsTo(GrantProgram::class);
    }

    public function grantType()
    {
        return $this->belongsTo(GrantType::class, 'type_of_grant_id');
    }

    public function grantingOrganization()
    {
        return $this->belongsTo(GrantOffice::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This GrantProgram has been {$eventName}");
    }


}
