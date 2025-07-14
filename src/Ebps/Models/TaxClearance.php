<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TaxClearance extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'org_tax_clearances';

    protected $fillable = [
        'organization_detail_id',
        'document',
        'year',
    ];

    public function casts():array{
        return [
            'organization_detail_id' => 'integer',
            'document'  => 'string',
            'year' =>'string'
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This StructureType has been {$eventName}");
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

}
