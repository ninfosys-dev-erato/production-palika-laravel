<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\FormSigneeName;

class FormSigneeNameDto
{
    public function __construct(
        public string $work_order_id,
        public string $signee_id,
        public ?int $id = null,

    ) {}

    public static function fromLivewire(string $workOrderId, string $signeeId,  ?int $id = null): self
    {
        return new self(
            work_order_id: $workOrderId,
            signee_id: $signeeId,
            id: $id,
        );
    }
}
