<?php

namespace Src\Beruju\DTO;

use Src\Beruju\Models\SubCategory;

class SubCategoryAdminDto
{
    public function __construct(
        public string $name_eng,
        public string $name_nep,
        public string $slug,
        public ?int $parent_id = null,
        public ?string $parent_name_eng = null,
        public ?string $parent_name_nep = null,
        public ?string $parent_slug = null,
        public ?string $remarks = null,
    ) {}

    public static function fromLiveWireModel(SubCategory $subCategory): SubCategoryAdminDto
    {
        return new self(
            name_eng: $subCategory->name_eng,
            name_nep: $subCategory->name_nep,
            slug: $subCategory->slug,
            parent_id: $subCategory->parent_id,
            parent_name_eng: $subCategory->parent_name_eng,
            parent_name_nep: $subCategory->parent_name_nep,
            parent_slug: $subCategory->parent_slug,
            remarks: $subCategory->remarks,
        );
    }

    public static function fromRequest(array $data): SubCategoryAdminDto
    {
        return new self(
            name_eng: $data['name_eng'],
            name_nep: $data['name_nep'],
            slug: $data['slug'],
            parent_id: $data['parent_id'] ?? null,
            parent_name_eng: $data['parent_name_eng'] ?? null,
            parent_name_nep: $data['parent_name_nep'] ?? null,
            parent_slug: $data['parent_slug'] ?? null,
            remarks: $data['remarks'] ?? null,
        );
    }

    public static function fromModel(SubCategory $subCategory): SubCategoryAdminDto
    {
        return new self(
            name_eng: $subCategory->name_eng,
            name_nep: $subCategory->name_nep,
            slug: $subCategory->slug,
            parent_id: $subCategory->parent_id,
            parent_name_eng: $subCategory->parent_name_eng,
            parent_name_nep: $subCategory->parent_name_nep,
            parent_slug: $subCategory->parent_slug,
            remarks: $subCategory->remarks,
        );
    }

    public function toArray(): array
    {
        return [
            'name_eng' => $this->name_eng,
            'name_nep' => $this->name_nep,
            'slug' => $this->slug,
            'parent_id' => $this->parent_id,
            'parent_name_eng' => $this->parent_name_eng,
            'parent_name_nep' => $this->parent_name_nep,
            'parent_slug' => $this->parent_slug,
            'remarks' => $this->remarks,
        ];
    }
}
