<?php

namespace Src\Settings\Service;

use Illuminate\Support\Facades\Auth;
use Src\Settings\DTO\FormAdminDto;
use Src\Settings\DTO\FormTemplateAdminDto;
use Src\Settings\Models\Form;

class FormAdminService
{

    public function store(FormAdminDto $formAdminDto)
    {
        return Form::create([
            'title' => $formAdminDto->title,
            'module' => $formAdminDto->module,
            'fields' => json_encode($formAdminDto->fields, JSON_UNESCAPED_SLASHES),

            'created_by' => Auth::id(),
            'ward_no' => Auth::user()->ward ?? null,
        ]);

    }

    public function template(Form $form, FormTemplateAdminDto $formAdminDto): Form
    {
        $form->update([
            'template' => $formAdminDto->template,
        ]);
        return $form;
    }

    public function update($form, FormAdminDto $formAdminDto, int $id): Form
    {
        return Form::updateOrCreate(
            ['id' => $id], [
                'module' => $formAdminDto->module,
            'title' => $formAdminDto->title,
            'fields' => json_encode($formAdminDto->fields),
            'updated_by' => Auth::id(),
        ]);

    }

    public function delete(Form $form)
    {
        return $form->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);

    }

    public function collectionDelete(array $ids): void
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        Form::whereIn('id', $numericIds)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);


    }
}
