<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class FourBoundary extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'ebps_four_boundaries';

    protected $fillable = [
'land_detail_id',
'title',
'direction',
'distance',
'lot_no',
'created_at',
'created_by',
'deleted_at',
'deleted_by',
'updated_at',
'updated_by'
];

    public function casts():array{
      return [
    'land_detail_id' => 'string',
    'title' => 'string',
    'direction' => 'string',
    'distance' => 'string',
    'lot_no' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This FourBoundary has been {$eventName}");
        }

        public function landDetail()
        {
            return $this->belongsTo(CustomerLandDetail::class);
        }

}
