<?php

namespace Src\Downloads\Models;

use Database\Factories\DownloadFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Download extends Model
{
    use HasFactory,LogsActivity;
    protected $table = 'tbl_downloads';

    protected $fillable = [
        'title',
        'title_en',
        'files',
        'status',
        'order',
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
            'title_en' => 'string',
            'files' => 'array',
            'status' => 'boolean',
            'order' => 'int',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
        ];
    }
    protected static function newFactory(): DownloadFactory|Factory
    {
        return DownloadFactory::new();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }
}
