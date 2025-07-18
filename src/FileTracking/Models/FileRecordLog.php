<?php

namespace Src\FileTracking\Models;

use App\Facades\FileFacade;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class FileRecordLog extends Model
{
    use HasFactory;

    protected $table = 'tbl_file_record_logs';

    protected $fillable = [
        'reg_id',
        'status',
        'file',
        'notes',
        'handler_type',
        'handler_id',
        'sender_type',
        'sender_id',
        'receiver_type',
        'receiver_id',
        'wards',
        'departments',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by'
    ];

    public function casts(): array
    {
        return [
            'reg_id' => 'string',
            'status' => 'string',
            'notes' => 'string',
            'handler_type' => 'string',
            'handler_id' => 'string',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
        ];
    }

    public function fileRecord()
    {
        return $this->belongsTo(FileRecord::class, 'reg_id');
    }
    public function handler(): MorphTo
    {
        return $this->morphTo();
    }

    public function receiver(): MorphTo{
        return $this->morphTo();
    }
    public function sender(): MorphTo{
        return $this->morphTo();
    }

    public function getFileAddressAttribute(){
        return FileFacade::getTemporaryUrl(
            path:config("src.FileTracking.fileTracking.file"),
            filename:$this->file,
            disk:"local",
            minutes:3,
        );
    }

}
