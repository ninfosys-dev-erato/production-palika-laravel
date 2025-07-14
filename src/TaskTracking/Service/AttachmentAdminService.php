<?php

namespace Src\TaskTracking\Service;

use Illuminate\Support\Facades\Auth;
use Src\TaskTracking\DTO\AttachmentAdminDto;
use Src\TaskTracking\Models\Attachment;

class AttachmentAdminService
{
public function store(AttachmentAdminDto $attachmentAdminDto){
    return Attachment::create([
        'file' => json_encode($attachmentAdminDto->file),
        'attachable_type' => $attachmentAdminDto->attachable_type,
        'attachable_id' => $attachmentAdminDto->attachable_id,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Attachment $attachment, AttachmentAdminDto $attachmentAdminDto){
    return tap($attachment)->update([
        'file' => $attachmentAdminDto->file,
        'attachable_type' => $attachmentAdminDto->attachable_type,
        'attachable_id' => $attachmentAdminDto->attachable_id,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Attachment $attachment){
    return tap($attachment)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Attachment::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


