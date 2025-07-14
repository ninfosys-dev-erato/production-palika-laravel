<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\PlanTemplate;

class PlanTemplateAdminDto
{
   public function __construct(
        public string $type,
        public string $template_for,
        public string $title,
        public string $data
    ){}

public static function fromLiveWireModel(PlanTemplate $planTemplate):PlanTemplateAdminDto{
    return new self(
        type: $planTemplate->type,
        template_for: $planTemplate->template_for,
        title: $planTemplate->title,
        data: $planTemplate->data
    );
}
}
