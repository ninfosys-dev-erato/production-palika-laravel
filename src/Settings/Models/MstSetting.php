<?php

namespace Src\Settings\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class MstSetting extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'mst_admin_settings';

    protected $fillable = [
        'group_id',
        'label',
        'label_ne',
        'value',
        'key_id',
        'key_type',
        'key_needle',
        'key',
        'description',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by'
    ];

    public function casts():array{
      return [
    'group_id' => 'string',
    'label' => 'string',
    'value' => 'string',
    'key_id' => 'string',
    'key_type' => 'string',
    'key_needle' => 'string',
    'key' => 'string',
    'description' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This Setting has been {$eventName}");
        }

}
