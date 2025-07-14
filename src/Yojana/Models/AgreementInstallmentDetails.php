<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AgreementInstallmentDetails extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_agreement_installment_details';

    protected $fillable = [
        'agreement_id',
        'installment_number',
        'release_date',
        'cash_amount',
        'goods_amount',
        'percentage',
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
            'agreement_id' => 'int',
            'installment_number' => 'int',
            'release_date' => 'string',
            'cash_amount' => 'int',
            'goods_amount' => 'int',
            'percentage' => 'int',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This Agreement Installment Detail has been {$eventName}");
    }


    public function agreement()
    {
        return $this->belongsTo(Agreement::class, 'agreement_id', 'id');
    }
}
