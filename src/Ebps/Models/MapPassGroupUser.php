<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class MapPassGroupUser extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'ebps_map_pass_group_user';

    protected $fillable = [
        'map_pass_group_id',
        'user_id',
        'ward_no',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by'
    ];

    public function casts():array
    {
      return [
    'map_pass_group_id' => 'string',
    'user_id' => 'string',
    'ward_no' => 'string',
    'id' => 'int',
    'created_at' => 'datetime',
    'created_by' => 'string',
    'updated_at' => 'datetime',
    'updated_by' => 'string',
    'deleted_at' => 'datetime',
    'deleted_by' => 'string',
];
    }


public function mapPassGroup()
{
    return $this->belongsTo(MapPassGroup::class, 'map_pass_group_id', 'id');
}


        public function getActivitylogOptions(): LogOptions
        {
            return LogOptions::defaults()
                ->logFillable()
                ->logOnlyDirty()
                ->setDescriptionForEvent(fn(string $eventName) => "This MapPassGroupUser has been {$eventName}");
        }

}
