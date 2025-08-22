<?php

namespace Src\Ejalas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Ejalas\Enum\PlaceOfRegistration;
use Src\FiscalYears\Models\FiscalYear;

class HearingSchedule extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jms_hearing_schedules';

    protected $fillable = [
        'hearing_paper_no',
        'fiscal_year_id',
        'hearing_date',
        'hearing_time',
        'reference_no',
        'reconciliation_center_id',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by',
        'complaint_registration_id',
        'template'
    ];

    public function casts(): array
    {
        return [
            'hearing_paper_no' => 'string',
            'fiscal_year_id' => 'string',
            'hearing_date' => 'string',
            'hearing_time' => 'string',
            'reference_no' => 'string',
            'reconciliation_center_id' => PlaceOfRegistration::class,
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
            'complaint_registration_id' => 'string',
            'template' => 'string',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This HearingSchedule has been {$eventName}");
    }
    public function fiscalYear()
    {
        return $this->belongsTo(FiscalYear::class, 'fiscal_year_id', 'id');
    }
    public function complaintRegistration()
    {
        return $this->belongsTo(ComplaintRegistration::class, 'complaint_registration_id', 'id');
    }
}
