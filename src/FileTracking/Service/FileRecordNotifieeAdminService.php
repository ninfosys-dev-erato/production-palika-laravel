<?php

namespace Src\FileTracking\Service;

use Illuminate\Support\Facades\Auth;
use Src\FileTracking\DTO\FileRecordNotifieeAdminDto;
use Src\FileTracking\Models\FileRecordNotifiee;

class FileRecordNotifieeAdminService
{
public function store(FileRecordNotifieeAdminDto $fileRecordNotifieeAdminDto)
{
    return FileRecordNotifiee::create([
        'file_record_log_id' => $fileRecordNotifieeAdminDto->file_record_log_id,
        'notifiable_type' => $fileRecordNotifieeAdminDto->notifiable_type,
        'notifiable_id' => $fileRecordNotifieeAdminDto->notifiable_id,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(FileRecordNotifiee $fileRecordNotifiee, FileRecordNotifieeAdminDto $fileRecordNotifieeAdminDto){
    return tap($fileRecordNotifiee)->update([
        'file_record_log_id' => $fileRecordNotifieeAdminDto->file_record_log_id,
        'notifiable_type' => $fileRecordNotifieeAdminDto->notifiable_type,
        'notifiable_id' => $fileRecordNotifieeAdminDto->notifiable_id,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(FileRecordNotifiee $fileRecordNotifiee){
    return tap($fileRecordNotifiee)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    FileRecordNotifiee::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


