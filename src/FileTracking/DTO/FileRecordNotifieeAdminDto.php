<?php

namespace Src\FileTracking\DTO;

use Illuminate\Database\Eloquent\Model;
use Src\FileTracking\Models\FileRecordNotifiee;

class FileRecordNotifieeAdminDto
{
   public function __construct(
        public string $file_record_log_id,
        public string $notifiable_type,
        public string $notifiable_id
    ){}

public static function fromLiveWireModel(FileRecordNotifiee $fileRecordNotifiee):FileRecordNotifieeAdminDto{
    return new self(
        file_record_log_id: $fileRecordNotifiee->file_record_log_id,
        notifiable_type: $fileRecordNotifiee->notifiable_type,
        notifiable_id: $fileRecordNotifiee->notifiable_id
    );
}

public static function fromServiceSession($file_record_log_id, $handlerModel){
   
    $class = get_class($handlerModel);
    $id = $handlerModel->id;
    return new self(
        file_record_log_id: $file_record_log_id,
        notifiable_type: $class,
        notifiable_id: $id
    );
   
}
}
