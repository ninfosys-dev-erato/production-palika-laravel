<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\LogBook;

class LogBookAdminDto
{
   public function __construct(
        public string $employee_id,
        public string $date,
        public string $visit_time,
        public string $return_time,
        public string $visit_type,
        public string $visit_purpose,
        public string $description
    ){}

public static function fromLiveWireModel(LogBook $logBook):LogBookAdminDto{
    return new self(
        employee_id: $logBook->employee_id,
        date: $logBook->date,
        visit_time: $logBook->visit_time,
        return_time: $logBook->return_time,
        visit_type: $logBook->visit_type,
        visit_purpose: $logBook->visit_purpose,
        description: $logBook->description
    );
}
}
