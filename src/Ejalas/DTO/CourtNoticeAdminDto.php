<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\CourtNotice;

class CourtNoticeAdminDto
{
   public function __construct(
        public string $notice_no,
        public string $fiscal_year_id,
        public string $complaint_registration_id,
        public string $reference_no,
        public string $notice_date,
        public string $notice_time,
        public string $reconciliation_center_id
    ){}

public static function fromLiveWireModel(CourtNotice $courtNotice):CourtNoticeAdminDto{
    return new self(
        notice_no: $courtNotice->notice_no,
        fiscal_year_id: $courtNotice->fiscal_year_id,
        complaint_registration_id: $courtNotice->complaint_registration_id,
        reference_no: $courtNotice->reference_no,
        notice_date: $courtNotice->notice_date,
        notice_time: $courtNotice->notice_time,
        reconciliation_center_id: $courtNotice->reconciliation_center_id
    );
}
}
