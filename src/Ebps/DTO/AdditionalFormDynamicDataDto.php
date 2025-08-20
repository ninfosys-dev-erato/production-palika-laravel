<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\AdditionalFormDynamicData;

class AdditionalFormDynamicDataDto
{
    public function __construct(
        public ?int $map_apply_id,
        public ?int $form_id,
        public ?string $form_data
    ) {}

    public static function fromLiveWireModel(AdditionalFormDynamicData $additionalFormDynamicData): AdditionalFormDynamicDataDto
    {
        return new self(
            map_apply_id: $additionalFormDynamicData->map_apply_id,
            form_id: $additionalFormDynamicData->form_id,
            form_data: $additionalFormDynamicData->form_data
        );
    }

    public static function fromArray(array $data): AdditionalFormDynamicDataDto
    {
        return new self(
            map_apply_id: $data['map_apply_id'] ?? null,
            form_id: $data['form_id'] ?? null,
            form_data: $data['form_data'] ?? null
        );
    }
}
