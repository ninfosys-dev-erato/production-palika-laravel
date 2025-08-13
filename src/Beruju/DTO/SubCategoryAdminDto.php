<?php

namespace Src\Beruju\DTO;

use Src\Beruju\Models\SubCategory;

class SubCategoryAdminDto
{
    public function __construct(
        public string $name,
        public string $slug,
        public ?int $parent_id = null,
        public ?string $parent_name = null,
        public ?string $parent_slug = null,
        public ?string $remarks = null,
    ) {}

    public static function fromLiveWireModel(SubCategory $subCategory): SubCategoryAdminDto
    {
        return new self(
            name: $subCategory->name,
            slug: $subCategory->slug,
            parent_id: $subCategory->parent_id,
            parent_name: $subCategory->parent_name,
            parent_slug: $subCategory->parent_slug,
            remarks: $subCategory->remarks,
        );
    }

    public static function fromRequest(array $data): SubCategoryAdminDto
    {
        return new self(
            name: $data['name'],
            slug: $data['slug'],
            parent_id: $data['parent_id'] ?? null,
            parent_name: $data['parent_name'] ?? null,
            parent_slug: $data['parent_slug'] ?? null,
            remarks: $data['remarks'] ?? null,
        );
    }

    public static function fromModel(SubCategory $subCategory): SubCategoryAdminDto
    {
        return new self(
            name: $subCategory->name,
            slug: $subCategory->slug,
            parent_id: $subCategory->parent_id,
            parent_name: $subCategory->parent_name,
            parent_slug: $subCategory->parent_slug,
            remarks: $subCategory->remarks,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'parent_id' => $this->parent_id,
            'parent_name' => $this->parent_name,
            'parent_slug' => $this->parent_slug,
            'remarks' => $this->remarks,
        ];
    }
}
