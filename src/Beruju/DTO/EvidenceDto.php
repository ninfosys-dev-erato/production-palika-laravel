<?php

namespace Src\Beruju\DTO;

use Src\Beruju\Models\Evidence;

class EvidenceDto
{
    public function __construct(
        public ?int $beruju_entry_id,
        public ?int $action_id,
        public ?string $name,
        public ?string $description,
        public ?string $evidence_document_name,
        public ?int $created_by = null,
    ) {}

    public static function fromArray(array $data): EvidenceDto
    {
        return new self(
            beruju_entry_id: $data['beruju_entry_id'] ?? null,
            action_id: $data['action_id'] ?? null,
            name: $data['name'] ?? null,
            description: $data['description'] ?? null,
            evidence_document_name: $data['evidence_document_name'] ?? null,

        );
    }

    public static function fromLiveWireModel(Evidence $evidence): EvidenceDto
    {
        return new self(
            beruju_entry_id: $evidence->beruju_entry_id,
            action_id: $evidence->action_id,
            name: $evidence->name,
            description: $evidence->description,
            evidence_document_name: $evidence->evidence_document_name,

        );
    }

    public function toArray(): array
    {
        return [
            'beruju_entry_id' => $this->beruju_entry_id,
            'action_id' => $this->action_id,
            'name' => $this->name,
            'description' => $this->description,
            'evidence_document_name' => $this->evidence_document_name,

        ];
    }
}
