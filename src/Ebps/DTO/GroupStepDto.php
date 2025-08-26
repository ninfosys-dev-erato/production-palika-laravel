<?php

namespace Src\Ebps\DTO;

class GroupStepDto
{
    public function __construct(
        public ?int $map_step_id = null,
        public ?int $submitter_group_id = null,
        public array $approver_group_ids = [],
        public ?string $created_by = null,
        public ?string $updated_by = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            map_step_id: $data['map_step_id'] ?? null,
            submitter_group_id: $data['submitter_group_id'] ?? null,
            approver_group_ids: $data['approver_group_ids'] ?? [],
            created_by: $data['created_by'] ?? null,
            updated_by: $data['updated_by'] ?? null,
        );
    }

    public static function fromModel($model): self
    {
        return new self(
            map_step_id: $model->map_step_id ?? null,
            submitter_group_id: $model->submitter_group_id ?? null,
            approver_group_ids: $model->approver_group_ids ?? [],
            created_by: $model->created_by ?? null,
            updated_by: $model->updated_by ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'map_step_id' => $this->map_step_id,
            'submitter_group_id' => $this->submitter_group_id,
            'approver_group_ids' => $this->approver_group_ids,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ];
    }

    /**
     * Validate the DTO data
     */
    public function validate(): array
    {
        $errors = [];

        if (!$this->map_step_id) {
            $errors['map_step_id'] = 'Map step ID is required';
        }

        // For steps that require submitter (Palika type), submitter group is required
        if ($this->map_step_id) {
            $step = \Src\Ebps\Models\MapStep::find($this->map_step_id);
            if ($step && $step->form_submitter === 'Palika' && !$this->submitter_group_id) {
                $errors['submitter_group_id'] = 'Submitter group is required for Palika steps';
            }
        }

        // At least one approver group should be selected
        if (empty($this->approver_group_ids)) {
            $errors['approver_group_ids'] = 'At least one approver group is required';
        }

        return $errors;
    }

    /**
     * Check if the DTO is valid
     */
    public function isValid(): bool
    {
        return empty($this->validate());
    }
} 