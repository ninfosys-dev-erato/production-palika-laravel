<?php

namespace Src\FileTracking\DTO;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Src\FileTracking\Enums\PatracharStatus;
use Src\FileTracking\Models\FileRecord;
use Src\FileTracking\Models\FileRecordLog;

class FileRecordLogAdminDto
{
   public function __construct(
        public string $reg_id,
        public string $status,
        public string $notes,
        public string $handler_type,
        public string $handler_id,
        public ?int $created_by,
        public ?string $file,
        public string $sender_type,
        public ?int $sender_id,
        public string $receiver_type,
        public ?int $receiver_id,
        public string $wards,
        public string $departments,
    ){}

    public static function fromLiveWireModel(FileRecordLog $fileRecordLog):FileRecordLogAdminDto{
    return new self(
        reg_id: $fileRecordLog->reg_id,
        status: $fileRecordLog->status,
        notes: $fileRecordLog->notes,
        handler_type: $fileRecordLog->handler_type,
        handler_id: $fileRecordLog->handler_id,
        created_by: $fileRecordLog->created_by,
        file: null,sender_type: "",sender_id: null,receiver_type: "",receiver_id: null,wards: "",departments: ""
    );
}

    public static function fromServiceSession(Model $handlerModel,string $notes ="" , $status ="",$reg_id = "", bool $admin = true){
        $class = get_class($handlerModel);
        $id = $handlerModel->id;
        return new self(
            reg_id: $reg_id,
            status: $status,
            notes: $notes,
            handler_type: $class,
            handler_id: $id,
            created_by: $admin ? Auth::user()->id : Auth::guard('customer')->id(),
            file:null,sender_type: "",sender_id: null,receiver_type: "",receiver_id: null,wards: "",departments: ""
        );
    }

    public static function fromPatracharForward(FileRecord $fileRecord,FileRecordLog $fileRecordLog, ?Model $recipient):self{
       return new self(
           reg_id: $fileRecord->main_thread_id??$fileRecord->id,
           status: $fileRecord->status??"forward",
           notes: $fileRecordLog->notes??"",
           handler_type: get_class(Auth::user()),
           handler_id: Auth::user()->id,
           created_by:Auth::user()->id ,
           file: $fileRecordLog->file,
           sender_type: $fileRecord->receiver_type??get_class(Auth::user()),
           sender_id: $fileRecord->receiver_id??Auth::user()->id,
           receiver_type: get_class($recipient),
           receiver_id: $recipient->id,
           wards: "",
           departments: ""
       );
    }

    public static function fromPatracharFarsyaut(FileRecord $fileRecord,FileRecordLog $fileRecordLog):self{
        return new self(
            reg_id: $fileRecord->main_thread_id??$fileRecord->id,
            status: "farsyaut",
            notes: $fileRecordLog->notes??"",
            handler_type: get_class(Auth::user()),
            handler_id: Auth::user()->id,
            created_by:Auth::user()->id ,
            file: $fileRecordLog->file,
            sender_type: $fileRecord->receiver_type??get_class(Auth::user()),
            sender_id: $fileRecord->receiver_id??Auth::user()->id,
            receiver_type: "",
            receiver_id: null,
            wards: "",
            departments: ""
        );
    }
}
