<?php

namespace Src\Beruju\Service;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Src\Beruju\DTO\EvidenceDto;
use Src\Beruju\Models\Evidence;

class EvidenceService
{
    public function store(EvidenceDto $evidenceDto): Evidence
    {
        $evidence = Evidence::create([
            'beruju_entry_id' => $evidenceDto->beruju_entry_id,
            'name' => $evidenceDto->name,
            'description' => $evidenceDto->description,
            'evidence_document_name' => $evidenceDto->evidence_document_name,
            'created_by' =>  Auth::id(),
        ]);

        return $evidence;
    }



    public function update(Evidence $evidence, EvidenceDto $evidenceDto): bool
    {
        $updateData = [
            'beruju_entry_id' => $evidenceDto->beruju_entry_id,
            'name' => $evidenceDto->name,
            'description' => $evidenceDto->description,
            'evidence_document_name' => $evidenceDto->evidence_document_name,
            'updated_by' => Auth::id(),
        ];

        return $evidence->update($updateData);
    }

    public function delete(Evidence $evidence): bool
    {
        return tap($evidence)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::id(),
        ]);
    }
}
