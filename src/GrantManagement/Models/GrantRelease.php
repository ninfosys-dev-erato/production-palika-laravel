<?php

namespace Src\GrantManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Src\Customers\Models\Customer;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class GrantRelease extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'gms_grant_release';

    protected $fillable = [
        'grantee_id',
        'grant_program_id',
        'grantee_type',
        'investment',
        'is_new_or_ongoing',
        'last_year_investment',
        'plot_no',
        'location',
        'contact_person',
        'grant_program',
        'contact_no',
        'condition',
        'deleted_by',
    ];

    public function casts(): array
    {
        return [
            'grantee_id' => 'string',
            'grantee_type' => 'string',
            'investment' => 'string',
            'is_new_or_ongoing' => 'string',
            'last_year_investment' => 'string',
            'plot_no' => 'string',
            'location' => 'string',
            'contact_person' => 'string',
            'contact_no' => 'string',
            'condition' => 'string',
            'grant_program' => 'string'
        ];
    }

    public function user()
    {
        return $this->belongsTo(Customer::class, 'grantee');
    }

    public function grantProgram(){
        return $this->belongsTo(GrantProgram::class, 'grant_program');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This GrantRelease has been {$eventName}");
    }
}
