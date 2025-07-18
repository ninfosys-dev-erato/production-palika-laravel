<?php

namespace Src\FileTracking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class FileRecordNotifiee extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'tbl_file_record_notifiees';

    protected $fillable = [
'file_record_log_id',
'notifiable_type',
'notifiable_id',
'created_at',
'created_by',
'deleted_at',
'deleted_by',
'updated_at',
'updated_by'
];

    public function casts():array{
      return [
    'file_record_log_id' => 'string',
    'notifiable_type' => 'string',
    'notifiable_id' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This FileRecordNotifiee has been {$eventName}");
        }

}
