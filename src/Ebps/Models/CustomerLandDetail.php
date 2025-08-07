<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\LocalBodies\Models\LocalBody;

class CustomerLandDetail extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'ebps_customer_land_details';

    protected $fillable = [
        'id',
        'customer_id',
        'local_body_id',
        'former_local_body',
        'former_ward_no',
        'ward',
        'tole',
        'area_sqm',
        'lot_no',
        'seat_no',
        'ownership',
        'is_landlord',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by'
    ];

    public function casts():array{
        return [
            'id' => 'int',
            'customer_id' => 'string',
            'local_body_id' => 'string',
            'former_local_body' => 'string',
            'former_ward_no' => 'string',
            'ward' => 'string',
            'tole' => 'string',
            'area_sqm' => 'string',
            'lot_no' => 'string',
            'seat_no' => 'string',
            'ownership' => 'string',
            'is_landlord' => 'string',

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
            ->setDescriptionForEvent(fn(string $eventName) => "This CustomerLandDetai has been {$eventName}");
    }
    public function fourBoundaries(): HasMany
    {
        return $this->hasMany(FourBoundary::class, 'land_detail_id');
    }        


    public function localBody(): BelongsTo
    {
        return $this->belongsTo(LocalBody::class, 'local_body_id');
    }

    public function formerLocalBody(): BelongsTo
    {
        return $this->belongsTo(LocalBody::class, 'local_body_id');
    }

}
