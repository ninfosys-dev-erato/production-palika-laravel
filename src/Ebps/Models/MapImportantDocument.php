<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class MapImportantDocument extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'ebps_map_important_documents';

    protected $fillable = [
'ebps_document_id',
'can_be_null',
'map_important_document_type',
'accepted_file_type',
'needs_approval',
'position',
'created_at',
'created_by',
'deleted_at',
'deleted_by',
'updated_at',
'updated_by'
];

    public function casts():array{
      return [
    'ebps_document_id' => 'string',
    'can_be_null' => 'string',
    'map_important_document_type' => 'string',
    'accepted_file_type' => 'string',
    'needs_approval' => 'string',
    'position' => 'string',
    'id' => 'int',
    'created_at' => 'datetime',
    'created_by' => 'string',
    'updated_at' => 'datetime',
    'updated_by' => 'string',
    'deleted_at' => 'datetime',
    'deleted_by' => 'string',
];
    }

    public function document()
    {
        return $this->belongsTo(Document::class, 'ebps_document_id', 'id');
    }

        public function getActivitylogOptions(): LogOptions
        {
            return LogOptions::defaults()
                ->logFillable()
                ->logOnlyDirty()
                ->setDescriptionForEvent(fn(string $eventName) => "This MapImportantDocument has been {$eventName}");
        }

}
