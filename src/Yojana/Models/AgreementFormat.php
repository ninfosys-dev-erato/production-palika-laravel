<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AgreementFormat extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_agreement_formats';

    protected $fillable = [
        'implementation_method_id',
        'name',
        'sample_letter',
        'styles',
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
            'implementation_method_id' => 'string',
            'name' => 'string',
            'sample_letter' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This AgreementFormat has been {$eventName}");
    }
    public function implementationMethod()
    {
        return $this->belongsTo(ImplementationMethod::class, 'implementation_method_id', 'id');
    }
}
