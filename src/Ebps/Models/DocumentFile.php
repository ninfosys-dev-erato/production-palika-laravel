<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Facades\FileFacade;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Src\BusinessRegistration\Enums\BusinessDocumentStatusEnum;

class DocumentFile extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'ebps_document_files';

    protected $fillable = [
        'map_apply_id',
        'title',
        'file',
        'status',
        'map_document_id',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by',
        'house_owner_id',
        'document_type',
    ];

    public function casts():array{
        return [
            'map_apply_id' => 'string',
            'title' => 'string',
            'file' => 'string',
            'status' => 'string',
            'map_document_id' => 'string',
            'id' => 'int',
            'house_owner_id' => 'int',
        'document_type' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This DocumentFile has been {$eventName}");
    }
     protected function url(): Attribute
    {
        
        return Attribute::make(
            get: function () {
                // Check if file attribute exists
                if (empty($this->file)) {
                    return null;
                }
                // For private files, generate a temporary signed URL
                return FileFacade::getTemporaryUrl(
                    path:config('src.Ebps.ebps.path'),
                    filename:$this->file,
                    disk:"local",
                    minutes:10,
                );
            }
        );
    }

}
