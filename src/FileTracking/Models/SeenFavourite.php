<?php

namespace Src\FileTracking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SeenFavourite extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'tbl_file_record_seen_favourites';

    protected $fillable = [
        'file_record_id',
        'status',
        'is_favourite',
        'is_archived',
        'user_type',
        'priority',
        'is_chalani',
        'user_id',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by'
        ];

    public function casts():array{
      return [
    'file_record_id' => 'string',
    'status' => 'string',
    'is_favourite' => 'string',
    'user_type' => 'string',
    'is_chalani' => 'string',
    'user_id' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This SeenFavourite has been {$eventName}");
        }

    public function fileRecord()
    {
        return $this->belongsTo(FileRecord::class, 'file_record_id');
    }
}
