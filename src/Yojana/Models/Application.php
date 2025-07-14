<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Application extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_applications';

    protected $fillable = [
        'applicant_name',
        'address',
        'mobile_number',
        'bank_id',
        'account_number',
        'is_employee',
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
            'applicant_name' => 'string',
            'address' => 'string',
            'mobile_number' => 'string',
            'bank_id' => 'string',
            'account_number' => 'string',
            'is_employee' => 'boolean',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This Application has been {$eventName}");
    }
    public function bankDetail()
    {
        return $this->belongsTo(BankDetail::class, 'bank_id', 'id');
    }
}
