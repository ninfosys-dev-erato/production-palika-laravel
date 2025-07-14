<?php

namespace Src\FileTracking\Service;

use Illuminate\Support\Facades\Auth;
use Src\FileTracking\DTO\FileRecordLogAdminDto;
use Src\FileTracking\Models\FileRecordLog;

class FileRecordLogAdminService
{
    public function store(FileRecordLogAdminDto $fileRecordLogAdminDto){
        return FileRecordLog::create([
            'reg_id' => $fileRecordLogAdminDto->reg_id,
            'status' => $fileRecordLogAdminDto->status,
            'notes' => $fileRecordLogAdminDto->notes,
            'handler_type' => $fileRecordLogAdminDto->handler_type,
            'handler_id' => $fileRecordLogAdminDto->handler_id,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $fileRecordLogAdminDto->created_by,
            'file'=>$fileRecordLogAdminDto->file,
            'sender_type'=>$fileRecordLogAdminDto->sender_type,
            'sender_id'=>$fileRecordLogAdminDto->sender_id,
            'receiver_type'=>$fileRecordLogAdminDto->receiver_type,
            'receiver_id'=>$fileRecordLogAdminDto->receiver_id,
            'wards'=>$fileRecordLogAdminDto->wards,
            'departments'=>$fileRecordLogAdminDto->departments,
        ]);
    }
    public function update(FileRecordLog $fileRecordLog, FileRecordLogAdminDto $fileRecordLogAdminDto){
        return tap($fileRecordLog)->update([
            'reg_id' => $fileRecordLogAdminDto->reg_id,
            'status' => $fileRecordLogAdminDto->status,
            'notes' => $fileRecordLogAdminDto->notes,
            'handler_type' => $fileRecordLogAdminDto->handler_type,
            'handler_id' => $fileRecordLogAdminDto->handler_id,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
            'file'=>$fileRecordLogAdminDto->file,
            'sender_type'=>$fileRecordLogAdminDto->sender_type,
            'sender_id'=>$fileRecordLogAdminDto->sender_id,
            'receiver_type'=>$fileRecordLogAdminDto->receiver_type,
            'receiver_id'=>$fileRecordLogAdminDto->receiver_id,
            'wards'=>$fileRecordLogAdminDto->wards,
            'departments'=>$fileRecordLogAdminDto->departments,
        ]);
    }
    public function delete(FileRecordLog $fileRecordLog){
        return tap($fileRecordLog)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids){
         $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        FileRecordLog::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}


