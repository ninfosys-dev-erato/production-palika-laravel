<?php

namespace Src\Beruju\Service;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Src\Beruju\DTO\BerujuEntryDto;
use Src\Beruju\Models\BerujuEntry;

class BerujuEntryService
{
    public function store(BerujuEntryDto $berujuEntryDto): BerujuEntry
    {
        $berujuEntry = BerujuEntry::create([
            // Form fields from form.blade.php
            'fiscal_year_id' => $berujuEntryDto->fiscal_year_id,
            'audit_type' => $berujuEntryDto->audit_type,
            'entry_date' => $berujuEntryDto->entry_date,
            'reference_number' => $berujuEntryDto->reference_number,
            'branch_id' => $berujuEntryDto->branch_id,
            'project_id' => $berujuEntryDto->project_id,
            'beruju_category' => $berujuEntryDto->beruju_category,
            'sub_category_id' => $berujuEntryDto->sub_category_id,
            'amount' => $berujuEntryDto->amount,
            'currency_type' => $berujuEntryDto->currency_type,
            'legal_provision' => $berujuEntryDto->legal_provision,
            'action_deadline' => $berujuEntryDto->action_deadline,
            'description' => $berujuEntryDto->description,
            'notes' => $berujuEntryDto->notes,
            // Additional fields
            'status' => $berujuEntryDto->status,
            'submission_status' => $berujuEntryDto->submission_status,
            'created_by' => Auth::user()->id,
        ]);

        return $berujuEntry;
    }

    public function update(BerujuEntry $berujuEntry, BerujuEntryDto $berujuEntryDto): bool
    {
        $updateData = [
            // Form fields from form.blade.php
            'fiscal_year_id' => $berujuEntryDto->fiscal_year_id,
            'audit_type' => $berujuEntryDto->audit_type,
            'entry_date' => $berujuEntryDto->entry_date,
            'reference_number' => $berujuEntryDto->reference_number,
            'branch_id' => $berujuEntryDto->branch_id,
            'project_id' => $berujuEntryDto->project_id,
            'beruju_category' => $berujuEntryDto->beruju_category,
            'sub_category_id' => $berujuEntryDto->sub_category_id,
            'amount' => $berujuEntryDto->amount,
            'currency_type' => $berujuEntryDto->currency_type,
            'legal_provision' => $berujuEntryDto->legal_provision,
            'action_deadline' => $berujuEntryDto->action_deadline,
            'description' => $berujuEntryDto->description,
            'notes' => $berujuEntryDto->notes,
            // Additional fields
            'status' => $berujuEntryDto->status,
            'submission_status' => $berujuEntryDto->submission_status,
            'updated_by' => Auth::user()->id,
        ];

        return $berujuEntry->update($updateData);
    }

    public function delete(BerujuEntry $berujuEntry): bool
    {
        return tap($berujuEntry)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
