<?php

namespace Src\Beruju\DTO;

use Src\Beruju\Models\Action;

class ActionAdminDto
{
    public function __construct(
        public int $cycle_id,
        public int $action_type_id,
        public string $status = 'Pending',
        public ?string $remarks = null,
    ) {}

    public static function fromLiveWireModel(Action $action): ActionAdminDto
    {
        return new self(
            cycle_id: $action->cycle_id,
            action_type_id: $action->action_type_id,
            status: $action->status,
            remarks: $action->remarks,
        );
    }

    public static function fromRequest(array $data): ActionAdminDto
    {
        return new self(
            cycle_id: $data['cycle_id'],
            action_type_id: $data['action_type_id'],
            status: $data['status'] ?? 'Pending',
            remarks: $data['remarks'] ?? null,
        );
    }

    public static function fromModel(Action $action): ActionAdminDto
    {
        return new self(
            cycle_id: $action->cycle_id,
            action_type_id: $action->action_type_id,
            status: $action->status,
            remarks: $action->remarks,
        );
    }

    public function toArray(): array
    {
        return [
            'cycle_id' => $this->cycle_id,
            'action_type_id' => $this->action_type_id,
            'status' => $this->status,
            'remarks' => $this->remarks,
        ];
    }
}
