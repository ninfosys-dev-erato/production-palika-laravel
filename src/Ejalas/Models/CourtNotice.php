<?php

namespace Src\Ejalas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Ejalas\Enum\PlaceOfRegistration;
use Src\Settings\Models\FiscalYear;

class CourtNotice extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jms_court_notices';

    protected $fillable = [
        'notice_no',
        'fiscal_year_id',
        'complaint_registration_id',
        'reference_no',
        'notice_date',
        'notice_time',
        'reconciliation_center_id',
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
            'notice_no' => 'string',
            'fiscal_year_id' => 'string',
            'complaint_registration_id' => 'string',
            'reference_no' => 'string',
            'notice_date' => 'string',
            'notice_time' => 'string',
            'reconciliation_center_id' => PlaceOfRegistration::class,
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
            ->setDescriptionForEvent(fn(string $eventName) => "This CourtNotice has been {$eventName}");
    }
    public function complaintRegistration()
    {
        return $this->belongsTo(ComplaintRegistration::class, 'complaint_registration_id', 'id');
    }
    public function fiscalYear()
    {
        return $this->belongsTo(FiscalYear::class, 'fiscal_year_id', 'id');
    }
}
