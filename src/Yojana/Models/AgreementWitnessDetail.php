<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Employees\Models\Employee;


/**
 * @property string $agreement_id
 * @property string $employee_id
 * @property string $name
 * @property string $position
 * @property string $address
 * @property string $contact_number
 * @property string $date
 * @property bool $is_witness
 */
class AgreementWitnessDetail extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_agreement_witness_details';

    protected $fillable = [
        'agreement_id',
        'employee_id',
       
    ];

    public function casts(): array
    {
        return [
            'agreement_id' => 'string',
            'employee_id' => 'string',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn (string $eventName) => "This AgreementWitnessDetail has been {$eventName}");
    }

    public function agreement(): BelongsTo
    {
        return $this->belongsTo(Agreement::class, 'agreement_id', 'id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
