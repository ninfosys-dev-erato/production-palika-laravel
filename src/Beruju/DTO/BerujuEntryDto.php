<?php

namespace Src\Beruju\DTO;

use Src\Beruju\Models\BerujuEntry;

class BerujuEntryDto
{
    public function __construct(
        // Form fields from form.blade.php
        public ?int $fiscal_year_id,
        public ?string $audit_type,
        public ?string $entry_date,
        public ?string $reference_number,
        public ?int $branch_id,
        public ?int $project_id,
        public ?string $beruju_category,
        public ?int $sub_category_id,
        public ?float $amount,
        public ?string $currency_type,
        public ?string $legal_provision,
        public ?string $action_deadline,
        public ?string $description,
        public ?string $notes,
        // Additional fields
        public string $status,
        public string $submission_status,
    ) {}

    public static function fromLiveWireModel(BerujuEntry $berujuEntry): BerujuEntryDto
    {
        return new self(
            // Form fields from form.blade.php
            fiscal_year_id: $berujuEntry->fiscal_year_id ?? null,
            audit_type: $berujuEntry->audit_type ?? null,
            entry_date: $berujuEntry->entry_date ?? null,
            reference_number: $berujuEntry->reference_number ?? null,
            branch_id: $berujuEntry->branch_id ?? null,
            project_id: $berujuEntry->project_id ?? null,
            beruju_category: $berujuEntry->beruju_category ?? null,
            sub_category_id: $berujuEntry->sub_category_id ?? null,
            amount: $berujuEntry->amount ?? null,
            currency_type: $berujuEntry->currency_type ?? null,
            legal_provision: $berujuEntry->legal_provision ?? null,
            action_deadline: $berujuEntry->action_deadline ?? null,
            description: $berujuEntry->description ?? null,
            notes: $berujuEntry->notes ?? null,
            // Additional fields
            status: $berujuEntry->status ?? 'pending',
            submission_status: $berujuEntry->submission_status ?? 'draft',
        );
    }
}
