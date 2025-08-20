<?php

namespace Src\Beruju\DTO;

use Src\Beruju\Enums\BerujuStatusEnum;
use Src\Beruju\Enums\BerujuSubmissionStatusEnum;
use Src\Beruju\Models\BerujuEntry;
use Src\Beruju\Enums\BerujuAduitTypeEnum;
use Src\Beruju\Enums\BerujuCategoryEnum;
use Src\Beruju\Enums\BerujuCurrencyTypeEnum;

class BerujuEntryDto
{
    public function __construct(
        // Form fields from form.blade.php
        public ?string $name,
        public ?string $fiscal_year_id,
        public ?string $audit_type,
        public ?string $entry_date,
        public ?string $reference_number,
        public ?string $branch_id,
        public ?string $project,
        public ?string $beruju_category,
        public ?string $sub_category_id,
        public ?float $amount,
        public ?string $currency_type,
        public ?string $legal_provision,
        public ?string $action_deadline,
        public ?string $description,
        public ?string $beruju_description,
        public ?string $owner_name,
        public ?string $dafa_number,
        public ?string $notes,
        // Additional fields
        public ?string $status,
        public ?string $submission_status,
    ) {}

    public static function fromLiveWireModel(BerujuEntry $berujuEntry): BerujuEntryDto
    {
        return new self(
            // Form fields from form.blade.php
            name: $berujuEntry->name,
            fiscal_year_id: $berujuEntry->fiscal_year_id,
            audit_type: $berujuEntry->audit_type?->value ?? $berujuEntry->audit_type,
            entry_date: $berujuEntry->entry_date,
            reference_number: $berujuEntry->reference_number,
            branch_id: $berujuEntry->branch_id,
            project: $berujuEntry->project,
            beruju_category: $berujuEntry->beruju_category?->value ?? $berujuEntry->beruju_category,
            sub_category_id: $berujuEntry->sub_category_id,
            amount: $berujuEntry->amount,
            currency_type: $berujuEntry->currency_type?->value ?? $berujuEntry->currency_type,
            legal_provision: $berujuEntry->legal_provision,
            action_deadline: $berujuEntry->action_deadline,
            description: $berujuEntry->description,
            beruju_description: $berujuEntry->beruju_description,
            owner_name: $berujuEntry->owner_name,
            dafa_number: $berujuEntry->dafa_number,
            notes: $berujuEntry->notes,
            // Additional fields
            status: $berujuEntry->status?->value ?? BerujuStatusEnum::DRAFT->value,
            submission_status: $berujuEntry->submission_status?->value ?? BerujuSubmissionStatusEnum::DRAFT->value,
        );
    }
}
