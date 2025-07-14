<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\ReconciliationCenter;

class ReconciliationCenterAdminDto
{
    public function __construct(
        public string $reconciliation_center_title,
        public string $surname,
        public ?string $title,
        public ?string $subtile,
        public string $ward_id,
        public string $established_date
    ) {}

    public static function fromLiveWireModel(ReconciliationCenter $reconciliationCenter): ReconciliationCenterAdminDto
    {
        return new self(
            reconciliation_center_title: $reconciliationCenter->reconciliation_center_title,
            surname: $reconciliationCenter->surname,
            title: $reconciliationCenter->title,
            subtile: $reconciliationCenter->subtile,
            ward_id: $reconciliationCenter->ward_id,
            established_date: $reconciliationCenter->established_date
        );
    }
}
