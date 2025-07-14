<?php

namespace Src\Settings\DTO;


use phpseclib3\Math\BinaryField\Integer;
use Src\Settings\Models\LetterHead;

class LetterHeadAdminDto
{
    public function __construct(
        public string $header,
        public string $footer,
        public int $ward_no,
        public bool $is_active
    ){}

    public static function fromLiveWireModel(LetterHead $letterHead):LetterHeadAdminDto{
        return new self(
            header: $letterHead->header,
            footer: $letterHead->footer,
            ward_no: $letterHead->ward_no,
            is_active: $letterHead->is_active
        );
    }
}
