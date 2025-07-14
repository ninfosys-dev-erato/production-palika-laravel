<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\PlanTemplateAdminDto;
use Src\Yojana\Models\PlanTemplate;

class PlanTemplateAdminService
{
public function store(PlanTemplateAdminDto $planTemplateAdminDto){
    return PlanTemplate::create([
        'type' => $planTemplateAdminDto->type,
        'template_for' => $planTemplateAdminDto->template_for,
        'title' => $planTemplateAdminDto->title,
        'data' => $planTemplateAdminDto->data,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(PlanTemplate $planTemplate, PlanTemplateAdminDto $planTemplateAdminDto){
    return tap($planTemplate)->update([
        'type' => $planTemplateAdminDto->type,
        'template_for' => $planTemplateAdminDto->template_for,
        'title' => $planTemplateAdminDto->title,
        'data' => $planTemplateAdminDto->data,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(PlanTemplate $planTemplate){
    return tap($planTemplate)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    PlanTemplate::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


