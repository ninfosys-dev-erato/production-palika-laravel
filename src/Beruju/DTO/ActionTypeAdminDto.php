<?php

namespace Src\Beruju\DTO;

use Src\Beruju\Models\ActionType;

class ActionTypeAdminDto
{
    public function __construct(
        public string $name_eng,
        public string $name_nep,
        public ?int $sub_category_id = null,
        public ?string $remarks = null,
        public ?int $form_id = null,
    ) {}

    public static function fromLiveWireModel(ActionType $actionType): ActionTypeAdminDto
    {
        return new self(
            name_eng: $actionType->name_eng,
            name_nep: $actionType->name_nep,
            sub_category_id: $actionType->sub_category_id,
            remarks: $actionType->remarks,
            form_id: $actionType->form_id,
        );
    }

    public static function fromRequest(array $data): ActionTypeAdminDto
    {
        return new self(
            name_eng: $data['name_eng'],
            name_nep: $data['name_nep'],
            sub_category_id: $data['sub_category_id'] ?? null,
            remarks: $data['remarks'] ?? null,
            form_id: $data['form_id'] ?? null,
        );
    }

    public static function fromModel(ActionType $actionType): ActionTypeAdminDto
    {
        return new self(
            name_eng: $actionType->name_eng,
            name_nep: $actionType->name_nep,
            sub_category_id: $actionType->sub_category_id,
            remarks: $actionType->remarks,
            form_id: $actionType->form_id,
        );
    }

    public function toArray(): array
    {
        return [
            'name_eng' => $this->name_eng,
            'name_nep' => $this->name_nep,
            'sub_category_id' => $this->sub_category_id,
            'remarks' => $this->remarks,
            'form_id' => $this->form_id,
        ];
    }
}
