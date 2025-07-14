<?php

namespace Src\BusinessRegistration\Service;

use Src\BusinessRegistration\DTO\BusinessRequiredDocDto;
use Src\BusinessRegistration\Models\BusinessRequiredDoc;

class BusinessRequiredDocService
{
    public function store(BusinessRequiredDocDto $dto): BusinessRequiredDoc
    {
        return BusinessRequiredDoc::updateOrCreate(
            [
                'business_registration_id' => $dto->businessRegistrationId,
                'document_field' => $dto->documentField,
            ],
            [
                'document_label_en' => $dto->documentLabelEn,
                'document_label_ne' => $dto->documentLabelNe,
                'document_filename' => $dto->documentFilename,
            ]
        );
    }

    public function delete($id): bool
    {
        $doc = BusinessRequiredDoc::find($id);
        if ($doc) {
            return $doc->delete();
        }
        return false;
    }
    public function bulkSave(array $dtos): void
    {
        foreach ($dtos as $dto) {
            $this->store($dto);
        }
    }
}
