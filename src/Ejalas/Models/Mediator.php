<?php

namespace Src\Ejalas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\FiscalYears\Models\FiscalYear;
use Src\Wards\Models\Ward;

class Mediator extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jms_mediators';

    protected $fillable = [
        'fiscal_year_id',
        'listed_no',
        'mediator_name',
        'mediator_address',
        'ward_id',
        'training_detail',
        'mediator_phone_no',
        'mediator_email',
        'municipal_approval_date',
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
            'fiscal_year_id' => 'string',
            'listed_no' => 'string',
            'mediator_name' => 'string',
            'mediator_address' => 'string',
            'ward_id' => 'string',
            'training_detail' => 'string',
            'mediator_phone_no' => 'string',
            'mediator_email' => 'string',
            'municipal_approval_date' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This Mediator has been {$eventName}");
    }
    public function fiscalYear()
    {
        return $this->belongsTo(FiscalYear::class, 'fiscal_year_id', 'id');
    }
    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id', 'id');
    }
}
