<?php

namespace Src\GrantManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Src\Customers\Models\Customer;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string $grantee_id
 * @property string $grantee_type
 * @property string $investment
 * @property string $is_new_or_ongoing
 * @property string $last_year_investment
 * @property string $plot_no
 * @property string $location
 * @property string $contact_person
 * @property string $contact_no
 * @property string $condition
 * @property string $grant_program
 * @property string|null $grant_expenses
 * @property string|null $private_expenses
 */
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
        'grant_expenses',
        'private_expenses',
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
            'grant_program' => 'string',
            'grant_expenses' => 'string',
            'private_expenses' => 'string'
        ];
    }

    public function user()
    {
        return $this->belongsTo(Customer::class, 'grantee');
    }

    public function grantProgram()
    {
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
