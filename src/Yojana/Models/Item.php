<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Item extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'pln_items';

    protected $fillable = [
'title',
'type_id',
'code',
'unit_id',
'remarks',
'created_at',
'created_by',
'deleted_at',
'deleted_by',
'updated_at',
'updated_by'
];

    public function casts():array{
      return [
    'title' => 'string',
    'type_id' => 'string',
    'code' => 'string',
    'unit_id' => 'string',
    'remarks' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This Item has been {$eventName}");
        }

        public function Type() : BelongsTo
        {
            return $this->belongsTo(ItemType::Class);
        }
        public function unit() : BelongsTo
        {
            return $this->belongsTo(Unit::Class);
        }

}
