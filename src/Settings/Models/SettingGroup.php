<?php

namespace Src\Settings\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SettingGroup extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'mst_admin_setting_groups';

    protected $fillable = [
'group_name',
'group_name_ne',
'slug',
'is_public',
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
    'group_name' => 'string',
    'description' => 'string',
    'slug' => 'string',
    'is_public' => 'boolean',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This SettingGroup has been {$eventName}");
        }

    public function settings()
    {
        return $this->hasMany(MstSetting::class,'group_id');
    }

}
