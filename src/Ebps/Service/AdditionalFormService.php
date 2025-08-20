<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Src\Ebps\DTO\AdditionalFormDto;
use Src\Ebps\Models\AdditionalForm;

class AdditionalFormService
{
    public function store(AdditionalFormDto $additionalFormDto): AdditionalForm
    {
        $additionalForm = AdditionalForm::create([
            'name' => $additionalFormDto->name,
            'form_id' => $additionalFormDto->form_id,
            'status' => true,
            'created_by' => Auth::id(),
        ]);

        return $additionalForm;
    }

    public function update(AdditionalForm $additionalForm, AdditionalFormDto $additionalFormDto): bool
    {
        $updateData = [
            'name' => $additionalFormDto->name,
            'form_id' => $additionalFormDto->form_id,
        ];

        return $additionalForm->update($updateData);
    }

    public function delete(AdditionalForm $additionalForm): bool
    {
        return $additionalForm->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::id(),
        ]);
    }
}
