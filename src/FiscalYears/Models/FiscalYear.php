<?php

namespace Src\FiscalYears\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Ejalas\Models\ComplaintRegistration;

class FiscalYear extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'mst_fiscal_years';

    protected $fillable = [
        'year',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_by',
        'deleted_at'
    ];

    public function casts(): array
    {
        return [
            'year' => 'string',
            'created_by' => 'integer',
            'updated_by' => 'integer',
            'deleted_by' => 'integer',
            'deleted_at' => 'datetime',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }
    public function complaintRegistration()
    {
        return $this->hasMany(ComplaintRegistration::class);
    }
}
