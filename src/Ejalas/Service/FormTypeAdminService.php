<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\FormTypeAdminDto;
use Src\Ejalas\Models\FormType;

class FormTypeAdminService
{
    public function store(FormTypeAdminDto $formTypeAdminDto)
    {
        return FormType::create([
            'name' => $formTypeAdminDto->name,
            'form_id' => $formTypeAdminDto->form_id,
            'status' => $formTypeAdminDto->status ?? true,
            'form_type' => $formTypeAdminDto->form_type,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }

    public function update(FormType $formType, FormTypeAdminDto $formTypeAdminDto)
    {
        return tap($formType)->update([
            'name' => $formTypeAdminDto->name,
            'form_id' => $formTypeAdminDto->form_id,
            'status' => $formTypeAdminDto->status ?? $formType->status,
            'form_type' => $formTypeAdminDto->form_type,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }

    public function delete(FormType $formType)
    {
        return tap($formType)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        FormType::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
