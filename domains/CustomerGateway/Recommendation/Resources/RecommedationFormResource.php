<?php

namespace Domains\CustomerGateway\Recommendation\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecommedationFormResource extends JsonResource
{
    public function toArray(Request $request): array
    {

        $tableFields = [];
        $updatedFields = [];

        foreach (json_decode($this->fields, true) as $field) {
            if (is_array($field) && isset($field['type']) && $field['type'] === "table") {
                foreach ($field as $key => $value) {
                    if (is_numeric($key)) {
                        $tableFields[] = $value;
                    }
                }
                $field['fields'] = $tableFields;

                foreach (array_keys($field) as $key) {
                    if (is_numeric($key)) {
                        unset($field[$key]);
                    }
                }
            }
            $updatedFields[] = $field;
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'template' => $this->template,
            'fields' => $updatedFields,
            'module' => $this->module,
        ];
    }
}
