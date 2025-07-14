<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PaymentTaxDeduction extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_payment_tax_deductions';

    protected $fillable = [
        'payment_id',
        'name',
        'evaluation_amount',
        'rate',
        'amount',
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
            'payment_id' => 'int',
            'name' => 'string',
            'evaluation_amount' => 'int',
            'rate' => 'int',
            'amount' => 'int',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This payment tax deduction has been {$eventName}");
    }

    public function payment() :BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }

    public function configuration(): belongsTo
    {
        return $this->belongsTo(Configuration::class, 'name', 'id');
    }

}
