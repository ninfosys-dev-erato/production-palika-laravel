<?php

namespace Src\Beruju\Service;

use Illuminate\Support\Facades\Auth;
use Src\Beruju\DTO\SubCategoryAdminDto;
use Src\Beruju\Models\SubCategory;

class SubCategoryAdminService
{
    public function store(SubCategoryAdminDto $subCategoryAdminDto){
        return SubCategory::create([
            'name' => $subCategoryAdminDto->name,
            'slug' => $subCategoryAdminDto->slug,
            'parent_id' => $subCategoryAdminDto->parent_id,
            'parent_name' => $subCategoryAdminDto->parent_name,
            'parent_slug' => $subCategoryAdminDto->parent_slug,
            'remarks' => $subCategoryAdminDto->remarks,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }

    public function update(SubCategory $subCategory, SubCategoryAdminDto $subCategoryAdminDto){
        return tap($subCategory)->update([
            'name' => $subCategoryAdminDto->name,
            'slug' => $subCategoryAdminDto->slug,
            'parent_id' => $subCategoryAdminDto->parent_id,
            'parent_name' => $subCategoryAdminDto->parent_name,
            'parent_slug' => $subCategoryAdminDto->parent_slug,
            'remarks' => $subCategoryAdminDto->remarks,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }

    public function delete(SubCategory $subCategory){
        return tap($subCategory)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function collectionDelete(array $ids){
         $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        SubCategory::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
