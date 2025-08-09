<?php

namespace Src\Ebps\DTO;

class StepRoleDto
{
    public function __construct(
        public ?int $map_step_id = null,
        public array $submitter_role_ids = [],
        public array $approver_role_ids = [],
        public ?string $created_by = null,
        public ?string $updated_by = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            map_step_id: $data['map_step_id'] ?? null,
            submitter_role_ids: $data['submitter_role_ids'] ?? [],
            approver_role_ids: $data['approver_role_ids'] ?? [],
            created_by: $data['created_by'] ?? null,
            updated_by: $data['updated_by'] ?? null,
        );
    }

    public static function fromModel($model): self
    {
        return new self(
            map_step_id: $model->map_step_id ?? null,
            submitter_role_ids: $model->submitter_role_ids ?? [],
            approver_role_ids: $model->approver_role_ids ?? [],
            created_by: $model->created_by ?? null,
            updated_by: $model->updated_by ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'map_step_id' => $this->map_step_id,
            'submitter_role_ids' => $this->submitter_role_ids,
            'approver_role_ids' => $this->approver_role_ids,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ];
    }
} 